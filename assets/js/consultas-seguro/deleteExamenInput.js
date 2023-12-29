import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { examenesSeguroList } from "./addExamenInput.js";

const select2Options = {
    selectValue: "examen_id",
    selectNames: ["nombre"],
    parentModal: "#modalAddPrecioExamen",
    placeholder: "Seleccione el examen"
}

function deleteExamenInput(input) {

    const examenContainer = input.parentElement.parentElement;
    examenContainer.remove();
    
    validateExistingSelect2OnDelete({ parentModal: "#modalAddPrecioExamen" , selectClass: "examen", addButtonId: "#addExamenes", objList: examenesSeguroList, select2Options, optionId: "examen_id" });
}

window.deleteExamenInput = deleteExamenInput;