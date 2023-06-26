import getById from "../global/getById.js";

async function reprogramationCita(id) {
    const $form = document.getElementById("reprogramacion-cita");
    try {

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "cita_id";
        $form.appendChild($inputId);

    } catch (error) {
        console.log(error);
    }
}

window.reprogramationCita = reprogramationCita;