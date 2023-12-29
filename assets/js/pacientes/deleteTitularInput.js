import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { titularesList } from "./addTitularInput.js";

const select2Options = {
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    placeholder: "Seleccione un titular",
}

function deleteTitularInput(input) {

    const titulares = document.querySelectorAll(".titular");
    
    const titularContainer = input.parentElement.parentElement;
    titularContainer.remove();

    validateExistingSelect2OnDelete({parentModal: "#modalReg", selectClass: "titular", objList: titularesList, optionId: "paciente_id", addButtonId: "#addTitular", select2Options});

    // Si se elimina el segundo titular ocultarle el icono de eliminar
    if (titulares.length === 2) {
        document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div:nth-child(2)")[0].classList.add("d-none");
    }

}

window.deleteTitularInput = deleteTitularInput;