import addModule from "../global/addModule.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getById from "../global/getById.js";
import scrollTo from "../global/scrollTo.js";
import cleanValdiation from "../global/cleanValidations.js";
import { registerStatusConsulta } from "./mostrarConsultas.js";
import consultaEmergencia from "./consultaEmergencia.js";
import { updateConsultaSeguroSelect } from "../consultas-seguro/registrarConsultaSeguro.js";

async function addConsulta() {

    let defaultAlert = ".alert";

    // Validamos si se hace desde el historial-medico o desde el módulo de consultas
    if (document.querySelector(".alertHistorialMedicoConsulta") !== null) {
        defaultAlert = ".alertHistorialMedicoConsulta";
    }

    const $form = document.getElementById("info-consulta"),
        $alert = document.querySelector(defaultAlert);

    try {
        const formData = new FormData($form),

            data = {},
            examenes = [],
            referidos = [];
        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        data.es_emergencia === "2" || data.es_emergencia === "0" ? data.es_emergencia = false : data.es_emergencia = true;
        data.tipoConsulta === "examen" ? data.tipo_servicio = "1" : data.tipo_servicio = "2";

        // En caso de que sea de emergencia y titular únicamente
        if (data.pacienteBeneficiadoEmergencia === "0" && data.es_emergencia) {

            const infoPaciente = await getById("pacientes", data.paciente_id);
            data.cedula_beneficiado = infoPaciente.cedula;
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

        let referido = formData.getAll("referidos[]");
        referido.forEach(e => {
            const especialidad_id = {
                especialidad_id: e,
            }
            referidos.push(especialidad_id);
        })

        if (referido.length != 0) { data.referidos = referidos; }

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

            // Validamos que si se quiere insertar más de un recipe, no estén con información vacía
            if (medicamento.medicamento_id === "" && key > 0) throw { message: "Debe especificar el medicamento en el recipe" }
            if (medicamento.uso === "" && key > 0) throw { message: "Debe especificar el uso en el recipe" }

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

        if (!data.fecha_consulta) { data.fecha_consulta = new Date().toISOString().slice(0, 10); }
        if (!data.es_emergencia && data.seguro_id) delete data.seguro_id;
        if (data.es_emergencia) data.tipo_servicio = "2";
        if (!data.es_emergencia || document.getElementById("tipoConsultas").value === "examen") delete data.es_emergencia;
        if (data.pacienteBeneficiadoEmergencia === "0") delete data.pacienteBeneficiadoEmergencia;
        if (data.total_insumos > 0 && !("insumos" in data)) throw { message: "Debe especificar los insumos utilizados" }

        if (data.consultaPorEmergencia === "0" && data.consultaSinCitaPrevia === "0") {
            const infoCita = await getById("citas", data.cita_id);
            data.cedula_titular = infoCita.cedula_titular;
            data.especialidad_id = infoCita.especialidad_id;
            data.medico_id = infoCita.medico_id;
            data.paciente_id = infoCita.paciente_id;
            data.tipo_servicio = infoCita.tipo_servicio;
        }

        const registroExitoso = await addModule("consultas", "info-consulta", data, "Consulta registrada correctamente!", "#modalReg", defaultAlert, { success: false, error: true });

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        $form.reset();
        deleteElementByClass("newInput");
        cleanValdiation("info-consulta");
        // $("#tipoConsultas").val("consulta").change();
        consultaEmergencia({ value: "0" });
        // Si la consulta es por cita, luego de registrarse satisfactoriamente, 
        if (data?.cita_id) registerStatusConsulta.successfulConsulta = true;

        let registroFacturaExitoso = true;

        // En caso de que se decida registrar la consulta a la factura por emergencia
        if (registroExitoso.data !== null && data?.registrarFacturaBool === "1") {

            const facturaExitosa = await addModule("factura/consultaSeguro", "info-consulta", { consulta_id: registroExitoso.data.consulta_id, tipo_servicio: "consulta" }, "Consulta registrada correctamente!", "#modalReg", ".alert", { success: false, error: false });

            if (facturaExitosa?.result?.code === false) { registroFacturaExitoso = false; }
        }

        const hideModalHandler = ({ registroFacturaExitoso }) => {

            if (registroFacturaExitoso === false) {
                $alert.classList.remove("alert-success");
                $alert.classList.remove("alert-danger");
                $alert.classList.add("alert-warning");
                $alert.innerText = "La consulta fue registrada correctamente, pero la factura no pudo ser procesada por lo que deberá realizarla manualmente";
                $alert.classList.remove("d-none");
            }

            setTimeout(() => {

                $("#modalReg").modal("hide");
                $alert.classList.add("d-none");
                $alert.classList.remove("alert-success");
                $alert.classList.remove("alert-danger");
                $alert.classList.remove("alert-warning")
                document.getElementById("s-especialidad").classList.remove("is-valid");
            }, 1500);
        }

        hideModalHandler({ registroFacturaExitoso });

        $('#consultas').DataTable().ajax.reload();

        // Si el registro se hace por el módulo de consultas actualizar el select de las consultas aseguradas
        if (document.getElementById("consulta") !== null) await updateConsultaSeguroSelect("#modalRegAsegurada");

        await tipoConsultaSelect({ value: "consulta" });
        $("#s-paciente").val([]).trigger("change.select2");
        $("#cedula_beneficiado").val([]).trigger("change.select2");
        $("#s-seguro-emergencia").val([]).trigger("change.select2");
        cleanValdiation("info-consulta");

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

