import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getById from "../global/getById.js";
import scrollTo from "../global/scrollTo.js";
import cleanValdiation from "../global/cleanValidations.js";
import { registerStatusConsulta } from "./mostrarConsultas.js";

async function addConsulta() {

    const $form = document.getElementById("info-consulta"),
        $alert = document.querySelector(".alert");

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

        const registroExitoso = await addModule("consultas", "info-consulta", data, "Consulta registrada correctamente!");
        
        if (!registroExitoso.code) throw { result: registroExitoso.result };
        
        // En caso de que se decida registrar la consulta a la factura por emergencia
        if(registroExitoso.data !== null && data?.registrarFacturaBool === "1"){
            await addModule("factura/consultaSeguro", "info-consulta", {consulta_id: registroExitoso.data.consulta_id}, "Consulta registrada correctamente!");
        }
        
        $form.reset();
        deleteElementByClass("newInput");
        cleanValdiation("info-consulta");

        // Si la consulta es por cita, luego de registrarse satisfactoriamente, 
        if(data?.cita_id) registerStatusConsulta.successfulConsulta = true;

        setTimeout(() => {
            $("#modalReg").modal("hide");
            document.getElementById("s-especialidad").classList.remove("is-valid");
        }, 500);
        $('#consultas').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        
        scrollTo("modalRegBody");
        
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;

    }
}

window.addConsulta = addConsulta;
document.getElementById("info-consulta").addEventListener('submit', (event) => {
    event.preventDefault();
    addConsulta();
})

