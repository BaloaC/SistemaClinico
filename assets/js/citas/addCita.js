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
            data = {};
        let infoTitular;

        formData.forEach((value, key) => (data[key] = value));


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


        const registroExitoso = await addModule("citas", "info-cita", data, "Cita agendada exitosamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        cleanValdiation("info-cita");
        calendar.refetchEvents();

    } catch (error) {
        console.log(error);

        scrollTo("modalRegBody");
        
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addCita = addCita;