import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import validateInputs from "../global/validateInputs.js";

export let especialidadesList = null;
const select2Options = {
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione una especialidad"
}

let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById("modalReg");
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async () => {
    if (modalOpened === false) {

        dinamicSelect2({
            selectSelector: "#s-especialidad",
            selectValue: "especialidad_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una especialidad",
            ajax: true,
            ajaxUrl: "especialidades/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.medico-especialidad-id`);

                let selectedOptions = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-especialidad`).value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })

                const data1 = [];

                data?.data.forEach(object => {
                    const { especialidad_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                    let isDuplicate = false;

                    selectedOptions?.forEach(select => {
                        if (select == object.especialidad_id) {
                            isDuplicate = true;
                            return; // Salir del bucle forEach si se encuentra una duplicación
                        }
                    });

                    if (!isDuplicate) {
                        data1.push({ id: valorPropiedad1, text: valorPropiedad2 });
                    }
                });

                // Transforms the top-level key of the response object from 'data' to 'results'
                return { results: data1 };
            }
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());
modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen());

async function addMedicoEspecialidadInput(button, parentModal = "#modalReg") {

    clicks += 1;

    const inputClassOptions = {
        "#modalReg": {
            selectClass: "medico-especialidad-id",
            costoClass: "costo-especialidad",
            deleteButtonFunction: "deleteMedicoEspecialidadInput(this)",
            addButtonId: "#addMedicoEspecialidad"
        },
        "#modalAct": {
            selectClass: "medico-especialidad-act-id",
            costoClass: "costo-especialidad-act",
            deleteButtonFunction: "deleteMedicoEspecialidadInput(this, '#modalAct')",
            addButtonId: "#addMedicoEspecialidadAct"
        },
    };

    const { selectClass, costoClass, deleteButtonFunction, addButtonId } = inputClassOptions[parentModal];

    let template = `
    <div class="row align-items-end newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Especialidad</label>
            <select id="s-especialidad${clicks}" data-validate="true" class="form-control default-select ${selectClass}" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto">Costo especialidad</label>
            <input type="number" name="costo-especialidad" step="any" data-validate="true" data-type="price" class="form-control ${costoClass}"" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1">
            <button type="button" class="btn mt-4" onclick="${deleteButtonFunction}"><i class="fas fa-times m-0"></i></button>
        </div>
    </div>

    `;

    document.getElementById(button).insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-especialidad${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione una especialidad",
        parentModal: parentModal,
    })

    const select = document.getElementById(`s-especialidad${clicks}`);
    const optionVacio = document.createElement("option");
    optionVacio.value = "";
    select.insertBefore(optionVacio, select.firstChild)

    // Se inserta la nueva información
    dinamicSelect2({
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: parentModal,
        placeholder: select2Options.placeholder,
        ajax: true,
        ajaxUrl: "especialidades/consulta",
        queryPage: false,
        processResultsAjax: function (data, params) {

            const existingSelects = document.querySelectorAll(`.medico-especialidad-id`);

            if (data?.data.length <= existingSelects.length) {
                $(addButtonId).fadeOut("slow");
            }

            let selectedOptions = [];

            // Recorremos los select que existen
            existingSelects.forEach(select2 => {
                if (document.getElementById(`s-especialidad${clicks}`).value != select2.value) {
                    selectedOptions.push(select2.value);
                }
            })

            const data1 = [];

            data?.data.forEach(object => {
                const { especialidad_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                let isDuplicate = false;

                selectedOptions?.forEach(select => {
                    if (select == object.especialidad_id) {
                        isDuplicate = true;
                        return; // Salir del bucle forEach si se encuentra una duplicación
                    }
                });

                if (!isDuplicate) {
                    data1.push({ id: valorPropiedad1, text: valorPropiedad2 });
                }
            });

            // Transforms the top-level key of the response object from 'data' to 'results'
            return { results: data1 };
        }
    });

    validateInputs();
}

window.addMedicoEspecialidadInput = addMedicoEspecialidadInput;