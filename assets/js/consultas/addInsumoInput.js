import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";

export let insumosList = null;
const select2Options = {
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione el insumo"
}

let clicks = 0;
let modalOpened = false;
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async (parentModal) => {
    if(modalOpened === false){

        insumosList = await getAll("insumos/consulta");    
        
        dinamicSelect2({
            obj: insumosList,
            selectSelector: `#s-insumo`,
            selectValue: "insumo_id",
            selectNames: ["nombre"],
            parentModal: parentModal,
            placeholder: "Seleccione el insumo"
        });

        $("#s-insumo").on("change", () => {
            validateExistingSelect2OnChange({
                parentModal,
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
if(modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg")); 
if(modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegConsulta"));

function addInsumoInput(parentModal = "#modalReg") {


    const inputInsumos = document.querySelectorAll(".insumo-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputInsumos.length === 1) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector("div:nth-child(2)").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-12 col-md-5">
                <label for="insumo">Insumo</label>
                <select name="insumo_id" id="s-insumo${clicks}" class="form-control insumo-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="cantidad" class="p-0">Cantidad utilizada</label>
                <input type="number" step="any" name="cantidad" data-validate="true" data-type="number" class="form-control insumo-cant">
                <small class="form-text col-12">Solo se permiten números</small>
            </div>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this,'.insumo-id', '${parentModal}')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addInsumo").insertAdjacentHTML("beforebegin", template);


    let selectSelector = `#s-insumo${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: select2Options.placeholder,
        parentModal,
    })

    dinamicSelect2({
        obj: insumosList,
        selectSelector: selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal,
        placeholder: select2Options.placeholder
    });

    validateExistingSelect2({
        parentModal,
        selectSelector,
        selectClass: "insumo-id",
        addButtonId: "#addInsumo",
        objList: insumosList,
        select2Options,
        optionId: "insumo_id"
    });

    validateExistingSelect2OnChange({
        parentModal,
        selectSelector,
        selectClass: "insumo-id",
        objList: insumosList,
        select2Options,
        optionId: "insumo_id"
    });
    
    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal, selectSelector, selectClass: "insumo-id", objList: insumosList, select2Options, optionId: "insumo_id" }); });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;