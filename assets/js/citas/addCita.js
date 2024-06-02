import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getById from "../global/getById.js";
import scrollTo from "../global/scrollTo.js";
import { calendar } from "./calendarioCitas.js";

async function addCita() {

    const $form = document.getElementById("info-cita"),
        $alert = document.getElementById("alertAddCita");

    try {
        const formData = new FormData($form),
            data = {},
            examenes = [];
        let infoTitular;

        formData.forEach((value, key) => (data[key] = value));


        let examen = formData.getAll("examenes[]");
        examen.forEach(e => {
            const examen_id = {
                examen_id: e,
            }
            examenes.push(examen_id);
        })

        if (examenes.length != 0) { data.examenes = examenes; }

        if (data.tipoPacienteRadio === "beneficiado") {
            infoTitular = await getById("pacientes", data.titular_id);
        } else {
            infoTitular = await getById("pacientes", data.paciente_id);
            delete data.titular_id;
        }

        data.cedula_titular = infoTitular.cedula;

        if (data.tipo_cita == 1) {
            delete data.seguro_id;
        }

        if (infoTitular.tipo_paciente == 3 && data.tipo_cita == 2) {
            data.paciente_titular_id = infoTitular.paciente_id;
        }

        // Formatear la hora para evitar errores
        data.hora_entrada = `${data.hora_entrada}:00`;
        data.hora_salida = `${data.hora_salida}:00`;

        const horaEntradaObj = new Date();
        const horaEntrada = data.hora_entrada.split(":");
        horaEntradaObj.setHours(horaEntrada[0],horaEntrada[1]);

        const horaSalidaObj = new Date();
        const horaSalida = data.hora_salida.split(":");
        horaSalidaObj.setHours(horaSalida[0],horaSalida[1]);

        if (data.hora_entrada === data.hora_salida) throw { message: "La hora de salida debe ser superior a la hora de entrada" };
        if (horaEntradaObj > horaSalidaObj) throw { message: "La hora de entrada no puede ser superior a la de salida" }
        if (!(parseInt(data.hora_entrada.split(":")[0]) >= 8 && (parseInt(data.hora_entrada.split(":")[0]) <= 17)) || !(parseInt(data.hora_salida.split(":")[0]) >= 8 && (parseInt(data.hora_salida.split(":")[0]) <= 17))) throw { message: "Las citas no pueden ser fuera de horario laboral del centro médico" }

        if (data.tipo_servicio === "3") data.tipo_servicio = 2;

        const registroExitoso = await addModule("citas", "info-cita", data, "Cita agendada exitosamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        calendar.refetchEvents();
        cleanValdiation("info-cita");

    } catch (error) {
        console.log(error);

        scrollTo("modalRegBody");

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addCita = addCita;