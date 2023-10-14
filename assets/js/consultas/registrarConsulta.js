import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getById from "../global/getById.js";

async function addConsulta() {

    const $form = document.getElementById("info-consulta"),
        $alert = document.querySelector(".alert");
    const modalRegBody = document.getElementById("modalRegBody") ?? null;

    try {
        const formData = new FormData($form),

            data = {},
            examenes = [];
        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        console.log(data);

        if (data.consultaPorEmergencia === "0" && data.consultaSinCitaPrevia === "0") {
            const infoCita = await getById("citas", data.cita_id);
            data.cedula_titular = infoCita.cedula_titular;
            data.especialidad_id = infoCita.especialidad_id;
            data.medico_id = infoCita.medico_id;
            data.paciente_id = infoCita.paciente_id;

        }

        if (data.consultaPorEmergencia === "1") {
            data.es_emergencia = true;
        }

        // Eliminamos la propiedad para que evitar la validación de datos vacíos en back
        delete data.consultaPorEmergencia;
        delete data.consultaSinCitaPrevia;

        let examen = formData.getAll("examenes[]");
        examen.forEach(e => {
            const examen_id = {
                examen_id: e,
            }
            examenes.push(examen_id);
        })

        if (examenes.length != 0) { data.examenes = examenes; }

        const medicosPago = document.querySelectorAll(".medico-pago-id"),
            montoPago = document.querySelectorAll(".monto-pago"),
            pagos = [];

        medicosPago.forEach((value, key) => {
            const pago = {
                medico_id: value.value,
                monto: montoPago[key].value
            }
            pagos.push(pago);
        })

        if (pagos.length != 0 && pagos[0].medico_id != "" && pagos[0].monto != "") { data.pagos = pagos; }

        const $insumos = document.querySelectorAll(".insumo-id"),
            $insumosCant = document.querySelectorAll(".insumo-cant"),
            insumos = [];

        $insumos.forEach((value, key) => {
            const insumo = {
                insumo_id: value.value,
                cantidad: $insumosCant[key].value
            }
            insumos.push(insumo);
        })
        if (insumos.length != 0 && insumos[0].insumo_id != "" && insumos[0].cantidad != "") { data.insumos = insumos; }

        const medicamentos = document.querySelectorAll(".medicamento-id"),
            medicamentoUso = document.querySelectorAll(".uso-medicamento"),
            recipes = [];

        medicamentos.forEach((value, key) => {
            const medicamento = {
                medicamento_id: value.value,
                uso: medicamentoUso[key].value
            }
            recipes.push(medicamento);
        })

        if (recipes.length != 0 && recipes[0].medicamento_id != "" && recipes[0].uso != "") { data.recipes = recipes; }

        const indicacionesList = document.querySelectorAll(".indicaciones"),
            indicaciones = [];

        indicacionesList.forEach((value, key) => {
            const indicacion = {
                descripcion: value.value
            }
            indicaciones.push(indicacion);
        })

        if (indicaciones.length != 0 && indicaciones[0].descripcion != "") { data.indicaciones = indicaciones; }

        if(data.medicamentos > 0 && !("recipes" in data)) throw { message: "Debe especificar los medicamentos utilizados" }


        // TODO: Validar los inputs del paciente

        // if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.altura))) throw { message: "La altura no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.peso))) throw { message: "La cédula no es válida" };


        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        const registroExitoso = await addModule("consultas", "info-consulta", data, "Consulta registrada correctamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        Array.from(document.getElementById("info-consulta").elements).forEach(element => {
            element.classList.remove('valid');
        })
        $form.reset();
        $('#s-paciente').val([]).trigger('change');
        $('#s-examen').val([]).trigger('change');
        $('#s-insumo').val([]).trigger('change');
        $('#s-medicamento').val([]).trigger('change');
        $('#s-cita').val([]).trigger('change');
        $('#s-cita').empty().trigger('change');
        document.getElementById("s-cita").disabled = true;
        deleteElementByClass("newInput");
        setTimeout(() => {
            $("#modalReg").modal("hide");
        }, 500);
        $('#consultas').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;

        // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
        modalRegBody.scrollTo({
            top: 0,
            bottom: modalRegBody.scrollHeight,
            behavior: 'smooth'
        });
    }
}

window.addConsulta = addConsulta;
document.getElementById("info-consulta").addEventListener('submit', (event) => {
    event.preventDefault();
    addConsulta();
})

