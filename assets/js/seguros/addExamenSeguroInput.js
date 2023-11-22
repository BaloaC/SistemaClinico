import dinamicSelect2 from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
let modalOpened = false;
let examenesSeguroList = null;
const modalRegister = document.getElementById('modalReg');

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => {
    if(modalOpened === false){
        examenesSeguroList = await getAll("examenes/clinica");

        dinamicSelect2({
            obj: examenesSeguroList,
            selectSelector: `#s-examen_id`,
            selectValue: "examen_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un exámen"
        });

        modalOpened = true;
    }
})

async function addExamenSeguroInput() {

    clicks += 1;
    let template = `
    <div class="row align-items-center newInput">
        <hr class="mt-4">
            <div class="col-10">
                <div class="col-11">
                    <label for="examen">Exámen</label>
                    <select name="examen_id" id="s-examen_id${clicks}" class="form-control mb-3 examen" data-active="0" required>
                        <option value="" selected>Seleccione un exámen</option>
                    </select>
                </div>
                <div class="col-11">
                    <label for="costo">Costo</label>
                    <input type="number" step="any" name="costo" class="form-control costos" data-validate="true" data-type="price" data-max-length="5" required>
                    <small class="form-text">No se permiten números negativos</small>
                </div>
            </div>
            <div class="col-2">
                <button type="button" class="btn" onclick="deleteExamenSeguroInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addExamen").insertAdjacentHTML("beforebegin", template);

    dinamicSelect2({
        obj: examenesSeguroList,
        selectSelector: `#s-examen_id${clicks}`,
        selectValue: "examen_id",
        selectNames: ["nombre"],
        parentModal: "#modalReg",
        placeholder: "Seleccione un exámen"
    });

    validateInputs();
}

window.addExamenSeguroInput = addExamenSeguroInput;