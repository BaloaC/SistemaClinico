import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
let modalOpened = false;
let medicosList = null;
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async (parentModal) => {
    if(modalOpened === false){

        medicosList = await getAll("medicos/consulta");    
        
        dinamicSelect2({
            obj: medicosList,
            selectSelector: `#s-medico-pago`,
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: parentModal,
            placeholder: "Seleccione un médico"
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
if(modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg")); 
if(modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegConsulta"));


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
    dinamicSelect2({
        obj: medicosList,
        selectSelector: `#s-medico-pago${clicks}`,
        selectValue: "medico_id",
        selectNames: ["cedula", "nombre-apellidos"],
        parentModal: parentModal,
        placeholder: "Seleccione un médico"
    });

    validateInputs();
}

window.addMedicoPagoInput = addMedicoPagoInput;