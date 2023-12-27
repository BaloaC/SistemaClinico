import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import { calendar } from "./calendarioCitas.js";

async function confirmReprogramation() {
    const $form = document.getElementById("reprogramacion-cita"),
        $alert = document.getElementById("reprogramacionAlert");

    try {

        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        const reprogramacionExitosa = await addModule(`citas/${data.cita_id}`,"reprogramacion-cita",data,"Cita reprogamada exitosamente!","#modalReprogramar",".reprogramacionAlert");
       
        if (!reprogramacionExitosa.code) throw { result: reprogramacionExitosa.result };

        calendar.refetchEvents();
        cleanValdiation("reprogramacion-cita");

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmReprogramation = confirmReprogramation;