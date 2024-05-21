import cleanValdiation from "../global/cleanValidations.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import { patterns } from "../global/patternsValidation.js";
import showDefaultModalAct from "../global/showDefaultModalAct.js";
import updateModule from "../global/updateModule.js";
import { listadoMedicosPagination, medicosPagination, pagination, ssrMedicosPagination } from "./medicosPagination.js";

function updateCostoEspecialidad(id, costo_especialidad) {

    const $form = document.getElementById("act-montoEspecialidad");
    document.getElementById("btn-confirmActMontoEspecialidad").setAttribute("onclick", `confirmUpdateCostoEspecialidad(${id})`)

    try {

        //Establecer el option con los datos del usuario
        $form.costo_especialidad.value = costo_especialidad;
        $form.costo_especialidad.dataset.secondValue = costo_especialidad;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "medico_especialidad_id";
        // ! Para evitar error sql del endpoint
        // $inputId.dataset.secondValue = id;
        $form.appendChild($inputId)

    } catch (error) {

        console.log(error);
    }
}


window.updateCostoEspecialidad = updateCostoEspecialidad;

async function confirmUpdateCostoEspecialidad() {

    const $form = document.getElementById("act-montoEspecialidad"),
        $alert = document.getElementById("actMontoEspecialidadAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(patterns.price.test(data.costo_especialidad))) throw { message: "El precio ingresado es inválido" };

        const parseData = deleteSecondValue("#act-montoEspecialidad input, #act-montoEspecialidad select", data);
       
        // Validamos que se envie al menos una propiedad para hacer la petición
        if (Object.values(parseData)?.length > 0) {

            await updateModule(parseData, "medico_especialidad_id", "especialidades/medicos", "act-montoEspecialidad", "Costo especialidad actualizado correctamente!", "actMontoEspecialidadAlert", "#modalActMontoEspecialidad");
            const listadoMedico = await ssrMedicosPagination(1);
            pagination.initializated = false;
            pagination.paginaActual = 1;
            medicosPagination(listadoMedico);
            listadoMedicosPagination.registros = listadoMedico;
        } else {

            showDefaultModalAct({ form: $form, successMessage: "Costo especialidad actualizado correctamente!", });
        }

        deleteElementByClass("newInput");
        cleanValdiation("act-medico");
        cleanValdiation("act-montoEspecialidad");
        cleanValdiation("info-medico");

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        scrollTo("modalActBody");

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdateCostoEspecialidad = confirmUpdateCostoEspecialidad;