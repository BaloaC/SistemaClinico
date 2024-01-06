import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";
import { examenesPagination, listadoExamenesPagination } from "./examenesPagination.js";

async function addExamen() {
    const $form = document.getElementById("info-examen"),
        alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 3) throw { message: "El nombre debe contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.price.test(data.precio_examen))) throw { message: "El nombre ingresado no es válido" };

        const registroExitoso = await addModule("examenes", "info-examen", data, "Exámen registrado exitosamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        const listadoExamenes = await getAll("examenes/consulta");
        cleanValdiation("info-examen");
        examenesPagination(listadoExamenes);
        listadoExamenesPagination.registros = listadoExamenes;

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        alert.textContent = error.message || error.result.message;
    }
}

window.addExamen = addExamen;
document.getElementsByName('tipo')[0].addEventListener('keydown', (event) => {
    if (event.key == 'Enter') {
        event.preventDefault();
        addExamen();
    }
})
