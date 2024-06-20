import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import { examenesPagination, listadoExamenesPagination, pagination, ssrExamanesRequest } from "./examenesPagination.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";
import showDefaultModalAct from "../global/showDefaultModalAct.js";
import dinamicSelect2, { emptySelect2 } from "../global/dinamicSelect2.js";

const especialidadSelect = document.getElementById("s-especialidad-act");

emptySelect2({
    selectSelector: especialidadSelect,
    placeholder: "Cargando",
    parentModal: "#modalAct",
});

dinamicSelect2({
    selectSelector: especialidadSelect,
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    parentModal: "#modalAct",
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

async function updateExamen(id) {

    const $form = document.getElementById("act-examen");

    try {

        const json = await getById("examenes", id);

        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.tipo.value = json.tipo;
        $form.tipo.dataset.secondValue = json.tipo;
        $form.precio_examen.dataset.secondValue = json.precio_examen;
        $form.precio_examen.value = json.precio_examen;
        
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
        alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {},
            especialidades = [];

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 3) throw { message: "El nombre debe contener al menos 3 caracteres"};
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

        const parseData = deleteSecondValue("#act-examen input, #act-examen select", data);

        delete parseData["especialidades[]"];
        
        // Validamos que se envie al menos una propiedad para hacer la petición
        if (Object.values(parseData)?.length > 1) {


            
            await updateModule(parseData, "examen_id", "examenes", "act-examen", "Examen actualizado correctamente!");
            $("#s-especialidad-act").val([]).trigger("change");
            const listadoExamenes = await ssrExamanesRequest(1);
            pagination.initializated = false;
            pagination.paginaActual = 1;
            examenesPagination(listadoExamenes);
            listadoExamenesPagination.registros = listadoExamenes;
        } else {

            showDefaultModalAct({form: $form, successMessage: "Examen actualizado correctamente!"});
        }

        cleanValdiation("act-examen");
        cleanValdiation("info-examen");

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        alert.textContent = message;

        setTimeout(() => {
            alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdate = confirmUpdate;
document.getElementById("act-examen").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdate();
})