import deleteSecondValue from "../global/deleteSecondValue.js";
import getById from "../global/getById.js";
import updateModule from "../global/updateModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

async function updateAntecedente(id) {

    const $form = document.getElementById("act-antecedente");

    try {
        const json = await getById("antecedentes", id);
        //Establecer el option con los datos del usuario
        $form.descripcion.value = json[0].descripcion;
        $form.descripcion.dataset.secondValue = json[0].descripcion;
        $form.tipo_antecedente_id.dataset.secondValue = json[0].tipo_antecedente_id;

        // Seleccionar el valor por defecto
        for (const option of $form.tipo_antecedente_id.options) {
            if (option.value == json[0].tipo_antecedente_id) {
                option.defaultSelected = true;
            }
        }

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "antecedentes_medicos_id";
        // ! Para evitar error sql del endpoint
        // $inputId.dataset.secondValue = id;
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateAntecedente = updateAntecedente;

async function confirmUpdate() {

    const id = location.pathname.split("/")[4];

    const $form = document.getElementById("act-antecedente"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const parseData = deleteSecondValue("#act-antecedente input, #act-antecedente select", data);

        await updateModule(parseData, "antecedentes_medicos_id", "antecedentes", "act-antecedente", "Antecedente actualizado exitosamente!");

        mostrarHistorialMedico(id);

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

document.getElementById("act-antecedente").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdate();
})
