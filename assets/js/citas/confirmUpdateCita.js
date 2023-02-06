import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import { calendar } from "./calendarioCitas.js";

async function confirmUpdate() {
    const $form = document.getElementById("act-cita"),
        $alert = document.getElementById("actAlert");

    try {

        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const parseData = deleteSecondValue("#act-cita input, #act-cita select", data);
        await updateModule(parseData, "cita_id", "citas", "act-cita", "Cita actualizada exitosamente!");
        calendar.refetchEvents();

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

window.confirmUpdate = confirmUpdate;