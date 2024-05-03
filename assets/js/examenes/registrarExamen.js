import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { emptySelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";
import { examenesPagination, listadoExamenesPagination, pagination, ssrExamanesRequest } from "./examenesPagination.js";

const especialidadSelect = document.getElementById("s-especialidad");

emptySelect2({
    selectSelector: especialidadSelect,
    placeholder: "Cargando",
    parentModal: "#modalReg",
});

dinamicSelect2({
    // obj: examenesList,
    selectSelector: especialidadSelect,
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    parentModal: "#modalReg",
    placeholder: "Seleccione las especialidades",
    multiple: true,
    ajax: true,
    ajaxUrl: "especialidades/consulta",
    processResultsAjax: function (data, params) {

        params.page = params.page || 1;

        const data1 = data?.data.map(object => {
            const { especialidad_id: valorPropiedad1, nombre: nombreExamen } = object;
            return { id: valorPropiedad1, text: nombreExamen };
        });

        // Transforms the top-level key of the response object from 'data' to 'results'
        return {
            results: data1,
            pagination: {
                more: data1.length
            }
        };
    }
});

async function addExamen() {
    const $form = document.getElementById("info-examen"),
        alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {},
            especialidades = [];

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 3) throw { message: "El nombre debe contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.price.test(data.precio_examen))) throw { message: "El nombre ingresado no es válido" };

        let especialidad = formData.getAll("especialidades[]");
        especialidad.forEach(e => {
            const especialidad_id = {
                especialidad_id: e,
            }
            especialidades.push(especialidad_id);
        })

        if (especialidades.length != 0) { data.especialidades = especialidades; }

        const registroExitoso = await addModule("examenes", "info-examen", data, "Exámen registrado exitosamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        const listadoExamenes = await ssrExamanesRequest(1);
        cleanValdiation("info-examen");
        pagination.initializated = false;
        pagination.paginaActual = 1;
        examenesPagination(listadoExamenes);
        // listadoExamenesPagination.registros = listadoExamenes;

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