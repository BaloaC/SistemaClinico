// import { mostrarEmpresas } from "./mostrarEmpresas.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import { mostrarExamenes } from "./mostrarExamenes.js";

async function updateExamen(id) {

    const $form = document.getElementById("act-examen");

    try {

        const json = await getById("examenes", id);

        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.tipo.value = json.tipo;
        $form.tipo.dataset.secondValue = json.tipo;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "examen_id";
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateExamen = updateExamen;

async function confirmUpdate() {
    const $form = document.getElementById("act-examen"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));
    
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.tipo))) throw { message: "El tipo ingresado no es válido" };

        const parseData = deleteSecondValue("#act-examen input, #act-examen select", data);

        await updateModule(parseData, "examen_id", "examenes", "act-examen", "Examen actualizado correctamente!");
        mostrarExamenes();

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
