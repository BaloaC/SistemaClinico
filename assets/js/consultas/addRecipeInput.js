import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";

export let medicamentosList = null;
const select2Options = {
    selectValue: "medicamento_id",
    selectNames: ["nombre_medicamento"],
    placeholder: "Seleccione el medicamento"
}

let clicks = 0;
let modalOpened = false;
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async (parentModal) => {
    if (modalOpened === false) {

        medicamentosList = await getAll("medicamento/consulta");

        dinamicSelect2({
            // obj: medicamentosList,
            selectSelector: `#s-medicamento`,
            selectValue: "medicamento_id",
            selectNames: ["nombre_medicamento"],
            parentModal: parentModal,
            placeholder: "Seleccione el medicamento",
            ajax: true,
            ajaxUrl: "medicamento/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.medicamento-id`);

                let selectedOptions = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-medicamento`).value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })

                const data1 = [];

                data?.data.forEach(object => {
                    const { medicamento_id: valorPropiedad1, nombre_medicamento: nombre_medicamento } = object;
                    let isDuplicate = false;

                    selectedOptions?.forEach(select => {
                        if (select == object.medicamento_id) {
                            isDuplicate = true;
                            return; // Salir del bucle forEach si se encuentra una duplicación
                        }
                    });

                    if (!isDuplicate) {
                        data1.push({ id: valorPropiedad1, text: nombre_medicamento });
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
if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
if (modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegConsulta"));

function addRecipeInput(parentModal = "#modalReg") {

    const inputRecipes = document.querySelectorAll(".medicamento-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputRecipes.length === 1) {
        document.querySelectorAll(".medicamento-id")[0].parentElement.parentElement.querySelector("div:nth-child(2)").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-start newInput">
            <div class="col-12 col-md-5">
                <label for="medicamento">Medicamento</label>
                <select name="medicamento_id" id="s-medicamento${clicks}" class="form-control medicamento-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="uso">Uso</label>
                <input type="text" name="uso" data-validate="true" data-type="address" class="form-control uso-medicamento">
                <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
            </div>
            <div class="col-3 col-md-1 pt-4-5">
                <button type="button" class="btn" onclick="deleteInput(this,'.medicamento-id')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addRecipe").insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-medicamento${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: select2Options.placeholder,
        parentModal,
    })

    dinamicSelect2({
        obj: medicamentosList,
        selectSelector: selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal,
        placeholder: select2Options.placeholder,
        ajax: true,
        ajaxUrl: "medicamento/consulta",
        queryPage: false,
        processResultsAjax: function (data, params) {

            const existingSelects = document.querySelectorAll(`.medicamento-id`);

            let selectedOptions = [];

            // Recorremos los select que existen
            existingSelects.forEach(select2 => {
                if (document.getElementById(`s-medicamento${clicks}`).value != select2.value) {
                    selectedOptions.push(select2.value);
                }
            })

            const data1 = [];

            data?.data.forEach(object => {
                const { medicamento_id: valorPropiedad1, nombre_medicamento: nombre_medicamento } = object;
                let isDuplicate = false;

                selectedOptions?.forEach(select => {
                    if (select == object.medicamento_id) {
                        isDuplicate = true;
                        return; // Salir del bucle forEach si se encuentra una duplicación
                    }
                });

                if (!isDuplicate) {
                    data1.push({ id: valorPropiedad1, text: nombre_medicamento });
                }
            });

            // Transforms the top-level key of the response object from 'data' to 'results'
            return { results: data1 };
        }
    });

    validateInputs();
}

window.addRecipeInput = addRecipeInput;