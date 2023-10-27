import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getAll from "../global/getAll.js";
import scrollTo from "../global/scrollTo.js";
import { mostrarSeguros } from "./mostrarSeguros.js";
import { segurosPagination } from "./segurosPagination.js";

async function addSeguro() {
    const $form = document.getElementById("info-seguro"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            examenes = [],
            costos = [],
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (data.nombre.length < 6) throw { message: "El nombre del seguro debe contener al menos 6 caracteres"};
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length !== 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length !== 4) throw { message: "El número ingresado no es válido" };

        data.telefono = data.cod_tel + data.telefono;
        data.rif = data.cod_rif + "-" + data.rif;

        const inputExamenes = document.querySelectorAll(".examen");
        const inputCostos = document.querySelectorAll(".costos");
        
        inputExamenes.forEach((input, key) => {
            examenes.push(input.value);
            costos.push(inputCostos[key].value);
        })

        if (examenes.length === 0 || costos.length === 0 ) throw { message: "No se ha seleccionado ningún exámen" };

        data.examenes = examenes;
        data.costos = costos;

        await addModule("seguros", "info-seguro", data, "Seguro registrado exitosamente!");

        scrollTo("modalRegBody");
        const listadoSeguros = await getAll("seguros/consulta");
        cleanValdiation("info-seguro");
        deleteElementByClass("newInput");
        segurosPagination(listadoSeguros);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addSeguro = addSeguro;