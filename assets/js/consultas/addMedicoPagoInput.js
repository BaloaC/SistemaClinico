import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";

export let medicosList = null;
const select2Options = {
    selectValue: "medico_id",
    selectNames: ["cedula", "nombre-apellidos"],
    placeholder: "Seleccione un médico"
}

let clicks = 0;
let modalOpened = false;
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async (parentModal) => {
    if (modalOpened === false) {

        medicosList = await getAll("medicos/consulta");

        dinamicSelect2({
            obj: medicosList,
            selectSelector: `#s-medico-pago`,
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: parentModal,
            placeholder: "Seleccione un médico"
        });

        $("#s-medico-pago").on("change", () => {
            validateExistingSelect2OnChange({
                parentModal,
                selectSelector: "#s-medico-pago",
                selectClass: "medico-pago-id",
                objList: medicosList,
                select2Options,
                optionId: "medico_id"
            });
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
if (modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegConsulta"));


function addMedicoPagoInput(parentModal = "#modalReg") {

    clicks += 1;
    let template = `

    <div class="row align-items-center newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Médico</label>
            <select id="s-medico-pago${clicks}" class="form-control medico-pago-id" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto" class="p-0">Monto</label>
            <input type="number" step="any" data-validate="true" data-type="price" class="form-control monto-pago" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1">
            <button type="button" class="btn" onclick="deleteInput(this,'.medico-pago-id')"><i class="fas fa-times m-0"></i></button>
        </div>
    </div>
    `;
    document.getElementById("addMedicoPago").insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-medico-pago${clicks}`;


    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: select2Options.placeholder,
        parentModal,
    })

    dinamicSelect2({
        obj: medicosList,
        selectSelector: selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal,
        placeholder: select2Options.placeholder
    });

    validateExistingSelect2({
        parentModal,
        selectSelector,
        selectClass: "medico-pago-id",
        addButtonId: "#addMedicoPago",
        objList: medicosList,
        select2Options,
        optionId: "medico_id"
    });

    validateExistingSelect2OnChange({
        parentModal,
        selectSelector,
        selectClass: "medico-pago-id",
        objList: medicosList,
        select2Options,
        optionId: "medico_id"
    });

    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal, selectSelector, selectClass: "medico-pago-id", objList: medicosList, select2Options, optionId: "medico_id" }); });

    validateInputs();
}

window.addMedicoPagoInput = addMedicoPagoInput;