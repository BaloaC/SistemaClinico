import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import { patterns } from "../global/patternsValidation.js";
import { getConsultasSegurosMes } from "./mostrarConsultaSeguro.js";

async function addPrecioExamenes() {

    const $form = document.getElementById("info-precioExamen"),
        $alert = document.querySelector(".addAlertPrecioExamen");

    try {

        const formData = new FormData($form),
            examenes = [],
            costos = [],
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const inputExamenes = document.querySelectorAll(".examen");
        const inputCostos = document.querySelectorAll(".costos");

        inputExamenes.forEach((input, key) => {
            examenes.push(input.value);
            costos.push(inputCostos[key].value);

            if (!patterns.price.test(inputCostos[key].value)) throw { message: "El precio ingresado es inválido" };
        })

        if (examenes.length === 0 || costos.length === 0) throw { message: "No se ha seleccionado ningún exámen" };

        data.costos = costos;
        data.examenes = examenes;

        const response = await addModule(`seguros/examenes/${data.seguro_id}`, "info-precioExamen", data, "Precio de exámenes registrados correctamente!", "#modalAddPrecioExamen", ".addAlertPrecioExamen");

        if (response?.code) {

            await getConsultasSegurosMes({ seguro: data.seguro_id });
            cleanValdiation("info-precioExamen");
            deleteElementByClass("newInput");
        }

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addPrecioExamenes = addPrecioExamenes;