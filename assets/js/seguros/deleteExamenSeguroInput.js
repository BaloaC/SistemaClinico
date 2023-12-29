import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { examenesSeguroList } from "./addExamenSeguroInput.js";

const select2Options = {
    selectValue: "examen_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione un exámen",
}

function deleteExamenSeguroInput(input) {

    // const examenSeguro = document.querySelectorAll(".examen");
    
    const deleteExamenSeguroInput = input.parentElement.parentElement;
    deleteExamenSeguroInput.remove();
    
    validateExistingSelect2OnDelete({ parentModal: "#modalReg" , selectClass: "examen", addButtonId: "#addExamen", objList: examenesSeguroList, select2Options, optionId: "examen_id" });

    // // Si se elimina el segundo titular ocultarle el icono de eliminar
    // if (titulares.length === 2) {
    //     document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div").classList.add("d-none");
    // }

}

window.deleteExamenSeguroInput = deleteExamenSeguroInput;