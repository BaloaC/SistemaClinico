import addModule from "../global/addModule.js";
import getAll from "../global/getAll.js";
import { examenesPagination } from "./examenesPagination.js";
import { mostrarExamenes } from "./mostrarExamenes.js";

async function addExamen() {
    const $form = document.getElementById("info-examen"),
        alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.tipo))) throw { message: "El tipo ingresado no es válido" };

        await addModule("examenes", "info-examen", data, "Exámen registrado exitosamente!");
        const listadoExamenes = await getAll("examenes/consulta");
        Array.from(document.getElementById("info-examen").elements).forEach(element => {
            element.classList.remove('valid');
        })
        examenesPagination(listadoExamenes);

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
