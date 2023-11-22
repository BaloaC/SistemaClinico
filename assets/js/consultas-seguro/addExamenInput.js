import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
let modalOpened = false;
let examenesSeguroList = null;
const modalAddExamenSeguro = document.getElementById("modalAddPrecioExamen");


const handleModalOpen = async () => {
    if(modalOpened === false){

        examenesSeguroList = await getAll("examenes/clinica");

        dinamicSelect2({
            obj: examenesSeguroList,
            selectSelector: "#s-examen_id",
            selectValue: "examen_id",
            selectNames: ["nombre"],
            parentModal: "#modalAddPrecioExamen",
            placeholder: "Seleccione el examen"
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
    dinamicSelect2({
        obj: examenesSeguroList,
        selectSelector: `#s-examen_id${clicks}`,
        selectValue: "examen_id",
        selectNames: ["nombre"],
        parentModal: "#modalAddPrecioExamen",
        placeholder: "Seleccione el examen"
    });

    validateInputs();
}

window.addExamenInput = addExamenInput;