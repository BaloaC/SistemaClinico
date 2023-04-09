import { select2OnClick } from "../global/dinamicSelect2.js";

export let clicks = 0;
function addInsumoInput() {

    clicks += 1;

    const insumoTemplate = document.getElementById("insumo-template").content;
    let clone = document.importNode(insumoTemplate, true);

    clone.getElementById("s-insumo").id = `s-insumo${clicks}`;
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
}

window.addInsumoInput = addInsumoInput;