import getById from "../global/getById.js";

async function updateCita(id) {
    const $form = document.getElementById("act-cita");
    try {

        const cita = await getById("citas", id);

        $form.clave.value = cita[0].clave;
        $form.clave.dataset.secondValue = cita[0].clave;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "cita_id";
        $form.appendChild($inputId);

    } catch (error) {
        console.log(error);
    }
}

window.updateCita = updateCita;