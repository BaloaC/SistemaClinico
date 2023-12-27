import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { especialidadesList } from "./addMedicoEspecialidadInput.js";

const select2Options = {
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione una especialidad"
}

function deleteMedicoEspecialidadInput(input, parentModal = "#modalReg") {

    const inputClassOptions = {
        "#modalReg": {
            selectClass: "medico-especialidad-id",

            addButtonId: "#addMedicoEspecialidad"
        },
        "#modalAct": {
            selectClass: "medico-especialidad-act-id",
            addButtonId: "#addMedicoEspecialidadAct"
        },
    };

    const { selectClass, addButtonId } = inputClassOptions[parentModal];

    const especialidadContainer = input.parentElement.parentElement;
    especialidadContainer.remove();

    validateExistingSelect2OnDelete({parentModal, selectClass, objList: especialidadesList, optionId: "especialidad_id", addButtonId, select2Options});
    
    // Si se elimina el segundo titular ocultarle el icono de eliminar
    // if (especialidad.length === 2) {
    //     document.querySelectorAll(".medico-especialidad-id")[0].parentElement.parentElement.querySelector("div")[2].classList.add("d-none");
    // }
}

window.deleteMedicoEspecialidadInput = deleteMedicoEspecialidadInput;