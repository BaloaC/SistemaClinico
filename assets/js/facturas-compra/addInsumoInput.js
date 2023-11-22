import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

export let clicks = 0;
let modalOpened = false;
let insumosList = null;
const modalRegister = document.getElementById("modalReg");

const handleModalOpen = async () => {
    if(modalOpened === false){

        insumosList = await getAll("insumos/consulta");
        const proveedoresList = await getAll("proveedores/consulta");

        dinamicSelect2({
            obj: proveedoresList,
            selectSelector: "#s-proveedor",
            selectValue: "proveedor_id",
            selectNames: ["proveedor_id", "nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un proveedor",
            selectWidth: "100%",
        });
        
        dinamicSelect2({
            obj: insumosList,
            selectSelector: "#s-insumo",
            selectValue: "insumo_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione el insumo",
            selectWidth: "100%",
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());

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

    dinamicSelect2({
        obj: insumosList,
        selectSelector: `#s-insumo${clicks}`,
        selectValue: "insumo_id",
        selectNames: ["nombre"],
        parentModal: "#modalReg",
        placeholder: "Seleccione el insumo",
        selectWidth: "100%"
    });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;