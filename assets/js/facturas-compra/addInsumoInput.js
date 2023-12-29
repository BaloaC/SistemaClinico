import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";


export let insumosList = null;
const select2Options = {
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione el insumo",
    selectWidth: "100%",
}

export let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById("modalReg");

const handleModalOpen = async () => {
    if (modalOpened === false) {

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

        $("#s-insumo").on("change", () => {
            validateExistingSelect2OnChange({
                parentModal: "#modalReg",
                selectSelector: "#s-insumo",
                selectClass: "insumo-id",
                objList: insumosList,
                select2Options,
                optionId: "insumo_id"
            });
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
    let selectSelector = `#s-insumo${clicks}`;

    const insumoTemplate = document.getElementById("insumo-template").content;
    let clone = document.importNode(insumoTemplate, true);

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione el insumo",
        parentModal: "#modalReg",
    })

    const select = clone.getElementById("s-insumo");
    const optionVacio = document.createElement("option");

    select.id = `s-insumo${clicks}`;
    optionVacio.value = "";
    select.insertBefore(optionVacio, select.firstChild)
    clone.querySelector("tr").classList.add("newInput");
    document.getElementById("insumos-list").appendChild(clone);

    dinamicSelect2({
        obj: insumosList,
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: "#modalReg",
        placeholder: select2Options.placeholder,
        selectWidth: "100%"
    });

    validateExistingSelect2({
        parentModal: "#modalReg",
        selectSelector,
        selectClass: "insumo-id",
        addButtonId: "#addInsumoInputBtn",
        objList: insumosList,
        optionId: "insumo_id",
        select2Options
    });

    validateExistingSelect2OnChange({
        parentModal: "#modalReg",
        selectSelector,
        selectClass: "insumo-id",
        objList: insumosList,
        optionId: "insumo_id",
        select2Options
    });

    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal: "#modalReg", selectSelector, selectClass: "insumo-id", objList: insumosList, optionId: "insumo_id", select2Options }); });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;