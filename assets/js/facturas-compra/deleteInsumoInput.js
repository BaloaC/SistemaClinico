import validateExistingSelect2OnDelete from "../global/validateExistingSelect2OnDelete.js";
import { insumosList } from "./addInsumoInput.js";

const select2Options = {
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione el insumo",
    selectWidth: "100%",
}

function deleteInsumoInput(input) {

    const inputInsumos = document.querySelectorAll(".insumo-id");

    const insumoContainer = input.parentElement.parentElement.parentElement,
        precioUnitario = insumoContainer.querySelector("input[name='precio_unit']"),
        unidades = insumoContainer.querySelector("input[name='unidades']");

    precioUnitario.value = 0;
    unidades.value = 0;
    precioUnitario.dispatchEvent(new Event('input', { bubbles: true }));
    unidades.dispatchEvent(new Event('input', { bubbles: true }));

    insumoContainer.remove();

    validateExistingSelect2OnDelete({parentModal: "#modalReg", selectClass: "insumo-id", objList: insumosList, optionId: "insumo_id", addButtonId: "#addInsumoInputBtn", select2Options});

    if (inputInsumos.length === 2) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector(".visible").classList.add("d-none")
    }
}

window.deleteInsumoInput = deleteInsumoInput;