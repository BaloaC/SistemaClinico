import { defaultSelect } from "../global/defaultSelect.js";
import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import getTitulares from "./getTitulares.js";

export let titularesList = null;
const select2Options = {
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    placeholder: "Seleccione un titular",
}

let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById('modalReg');
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async (parentModal) => {

    if(modalOpened === false){

        titularesList = await getTitulares();
        
        let selectSelectorTitular = parentModal === "#modalReg" ? "#s-titular_id" : "#s-titular_id-act";

        dinamicSelect2({
            obj: titularesList,
            selectSelector: selectSelectorTitular,
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: parentModal,
            placeholder: "Seleccione un titular"
        });

        $(selectSelectorTitular).on("change", () => {
            validateExistingSelect2OnChange({
                parentModal,
                selectSelector: selectSelectorTitular,
                selectClass: "titular",
                objList: titularesList,
                select2Options,
                optionId: "paciente_id"
            });
        });

        modalOpened = true;
    }
}
// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalAct"));

async function addTitularInput() {

    const inputTitulares = document.querySelectorAll(".titular");

    // Validamos que exista un solo titular para poder añadirle que se pueda eliminar
    if(inputTitulares.length === 1){
        document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <hr>
            <div class="col-12 col-md-5">
                <label for="titular">Titular</label>
                <select name="titular_id" id="s-titular_id${clicks}" class="form-control mb-3 titular" data-active="0" required>
                    <option value="" selected>Seleccione un titular</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Tipo de relación</label>
                <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3 default-select relacion" required>
                    <option value="" disabled selected>Seleccione el tipo de relación</option>
                    <option value="1">Seguro</option>
                    <option value="2">Natural</option>
                </select>
            </div>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteTitularInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_familiar">Tipo de familiar</label>
                <select name="tipo_familiar" id="tipo_familiar" class="form-control mb-3 default-select tipo_familiar" required>
                    <option value="" disabled selected>Seleccione el tipo de familiar</option>
                    <option value="1">Padre/Madre</option>
                    <option value="2">Representante</option>
                    <option value="3">Primo/a</option>
                    <option value="4">Hermano/a</option>
                    <option value="5">Esposo/a</option>
                    <option value="6">Tío/a</option>
                    <option value="7">Sobrino/a</option>
                </select>
            </div>
        </div>
    `;
    document.getElementById("addTitular").insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-titular_id${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione un titular",
        parentModal: "#modalReg",
    })

    dinamicSelect2({
        obj: titularesList,
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: "#modalReg",
        placeholder: select2Options.placeholder
    });

    validateExistingSelect2({
        parentModal: "#modalReg",
        selectSelector,
        selectClass: "titular",
        addButtonId: "#addTitular",
        objList: titularesList,
        optionId: "paciente_id",
        select2Options
    });
    
    validateExistingSelect2OnChange({
        parentModal: "#modalReg",
        selectSelector,
        selectClass: "titular",
        objList: titularesList,
        optionId: "paciente_id",
        select2Options
    });

    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal: "#modalReg", selectSelector, selectClass: "titular",  objList: titularesList, optionId: "paciente_id", select2Options }); });

    defaultSelect();
}

window.addTitularInput = addTitularInput;