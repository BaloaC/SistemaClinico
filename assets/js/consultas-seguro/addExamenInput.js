import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";
import { examenesSeguroListAll, infoSeguro } from "./mostrarConsultaSeguro.js";

export let examenesSeguroList = null;
const select2Options = {
    selectValue: "examen_id",
    selectNames: ["nombre"],
    parentModal: "#modalAddPrecioExamen",
    placeholder: "Seleccione el examen"
}

let clicks = 0;
let modalOpened = false;
const modalAddExamenSeguro = document.getElementById("modalAddPrecioExamen");

// let myVariable = 0;

// const handleChange = (newValue) => {
//   console.log('La variable ha cambiado:', newValue);
//   // Realizar acciones adicionales aquí
// };

// const variableProxy = new Proxy({ value: myVariable }, {
//   set(target, prop, value) {
//     target[prop] = value;

//     if (prop === 'value') {
//       handleChange(value);
//     }

//     return true;
//   }
// });

// // Prueba cambiando el valor de la variable
// variableProxy.value = 42;
// variableProxy.value = 'Hola mundo';

const handleModalOpen = async () => {
    if(modalOpened === false){

        
        examenesSeguroList = examenesSeguroListAll.filter(examenSeguro => !infoSeguro?.examenes.some(examen => examenSeguro.examen_id == examen.examen_id));

        // variableProxy.value = "soy yo";

        dinamicSelect2({
            obj: examenesSeguroList,
            selectSelector: "#s-examen_id",
            selectValue: "examen_id",
            selectNames: ["nombre"],
            parentModal: "#modalAddPrecioExamen",
            placeholder: "Seleccione el examen"
        });
        
        $("#s-examen_id").val(null).trigger("change");

        $("#s-examen_id").on("change", () => {
            validateExistingSelect2OnChange({
                parentModal: "#modalAddPrecioExamen",
                selectSelector: "#s-examen_id",
                selectClass: "examen",
                objList: examenesSeguroList,
                select2Options,
                optionId: "examen_id"
            });
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
modalAddExamenSeguro.addEventListener('show.bs.modal', async () => await handleModalOpen());

async function addExamenInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <hr>
            <div class="col-12 col-md-5">
                <label for="titular">Examen</label>
                <select name="examen_id[]" id="s-examen_id${clicks}" class="form-control examen" data-active="0" required>
                    <option value="" selected>Seleccione el examen</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Costo del examen</label>
                <input type="number" step="any" data-validate="true" data-type="price" data-max-length="6" class="form-control mb-3 costos" required>
                <small class="form-text">No se permiten números negativos</small>
            </div>
            <div class="col-3 col-md-1 mt-4">
                <button type="button" class="btn" onclick="deleteExamenInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;

    document.getElementById("addExamenes").insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-examen_id${clicks}`;


    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: select2Options.placeholder,
        parentModal: select2Options.parentModal,
    })

    
    dinamicSelect2({
        obj: examenesSeguroList,
        selectSelector: selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: select2Options.parentModal,
        placeholder: select2Options.placeholder
    });

    validateExistingSelect2({
        parentModal: select2Options.parentModal,
        selectSelector,
        selectClass: "examen",
        addButtonId: "#addExamenes",
        objList: examenesSeguroList,
        select2Options,
        optionId: "examen_id"
    });

    validateExistingSelect2OnChange({
        parentModal: select2Options.parentModal,
        selectSelector,
        selectClass: "examen",
        objList: examenesSeguroList,
        select2Options,
        optionId: "examen_id"
    });

    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal: select2Options.parentModal, selectSelector, selectClass: "examen", objList: examenesSeguroList, select2Options, optionId: "examen_id" }); });

    validateInputs();
}

window.addExamenInput = addExamenInput;