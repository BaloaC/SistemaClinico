import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { insumosList } from "./addInsumoInput.js";
import { medicosList } from "./addMedicoPagoInput.js";
import { medicamentosList } from "./addRecipeInput.js";



function deleteInput(input, inputRefName, parentModal = "#modalReg"){

    const select2Options = {
        "insumo-id": {
            selectValue: "insumo_id",
            selectNames: ["nombre"],
            placeholder: "Seleccione el insumo",
            list: insumosList,
            addButtonId: "#addInsumo"
        },
        "medico-pago-id": {
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            placeholder: "Seleccione un médico",
            list: medicosList,
            addButtonId: "#addMedicoPago"
        }, 
        "medicamento-id": {
            selectValue: "medicamento_id",
            selectNames: ["nombre_medicamento"],
            placeholder: "Seleccione el medicamento",
            list: medicamentosList,
            addButtonId: "#addRecipe"
        }
    }

    const inputList = document.querySelectorAll(inputRefName); 
    

    const inputContainer = input.parentElement.parentElement;
    inputContainer.remove();

    // Le quitamos el . para poder pasar la clase en los objetos
    let inputClass = inputRefName.substring(1);

    validateExistingSelect2OnDelete({ parentModal, selectClass: inputClass, addButtonId: select2Options[inputClass].addButtonId, objList: select2Options[inputClass].list, select2Options: select2Options[inputClass], optionId: select2Options[inputClass].selectValue});

    if (inputList.length === 2) {
        document.querySelectorAll(inputRefName)[0].parentElement.parentElement.querySelector("div:nth-child(2)")[0].classList.add("d-none");
    }
}

window.deleteInput = deleteInput;