import { defaultSelect } from "../global/defaultSelect.js";
import dinamicSelect2 from "../global/dinamicSelect2.js";
import getTitulares from "./getTitulares.js";

let clicks = 0;
let modalOpened = false;
let titulares = null;
const modalRegister = document.getElementById('modalReg');
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async (parentModal) => {
    if(modalOpened === false){
        titulares = await getTitulares();
        
        dinamicSelect2({
            obj: titulares,
            selectSelector: parentModal === "#modalReg" ? "#s-titular_id" : "#s-titular_id",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: parentModal,
            placeholder: "Seleccione un titular"
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

    dinamicSelect2({
        obj: titulares,
        selectSelector: `#s-titular_id${clicks}`,
        selectValue: "paciente_id",
        selectNames: ["cedula", "nombre-apellidos"],
        parentModal: "#modalReg",
        placeholder: "Seleccione un titular"
    });
    
    defaultSelect();
}

window.addTitularInput = addTitularInput;