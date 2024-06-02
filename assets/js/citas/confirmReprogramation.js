import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import scrollTo from "../global/scrollTo.js";
import { calendar } from "./calendarioCitas.js";

async function confirmReprogramation() {
    const $form = document.getElementById("reprogramacion-cita"),
        $alert = document.getElementById("reprogramacionAlert");

    try {

        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        data.accion = "reprogramar";

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


        const reprogramacionExitosa = await addModule(`citas/${data.cita_id}`, "reprogramacion-cita", data, "Cita reprogamada exitosamente!", "#modalReprogramar", ".reprogramacionAlert", undefined, "modalRegBodyReprogramar");

        if (!reprogramacionExitosa.code) throw { result: reprogramacionExitosa.result };

        calendar.refetchEvents();
        cleanValdiation("reprogramacion-cita");

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        scrollTo("modalRegBodyReprogramar");

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
        
    }
}

window.confirmReprogramation = confirmReprogramation;