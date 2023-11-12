import { select2OnClick } from "../global/dinamicSelect2.js";
import validateInputs from "../global/validateInputs.js";

export let clicks = 0;
function addInsumoInput() {


    const inputInsumos = document.querySelectorAll(".insumo-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputInsumos.length === 1) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector(".visible").classList.remove("d-none")
    }

    clicks += 1;

    const insumoTemplate = document.getElementById("insumo-template").content;
    let clone = document.importNode(insumoTemplate, true);

    clone.getElementById("s-insumo").id = `s-insumo${clicks}`;
    clone.querySelector("tr").classList.add("newInput");
    document.getElementById("insumos-list").appendChild(clone);

    select2OnClick({
        selectSelector: `#s-insumo${clicks}`,
        selectValue: "insumo_id",
        selectNames: ["nombre"],
        module: "insumos/consulta",
        parentModal: "#modalReg",
        placeholder: "Seleccione el insumo",
        selectWidth: "100%"
    });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;