import addModule from "../global/addModule.js";
import { mostrarExamenes } from "./mostrarExamenes.js";

async function addExamen() {
    const $form = document.getElementById("info-examen"),
        $alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.tipo))) throw { message: "El tipo ingresado no es válido" };

        await addModule("examenes", "info-examen", data, "Exámen registrado exitosamente!");
        mostrarExamenes();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addExamen = addExamen;

