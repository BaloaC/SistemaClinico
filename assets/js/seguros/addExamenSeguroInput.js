import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import validateInputs from "../global/validateInputs.js";

export let examenesSeguroList = null;
const select2Options = {
    selectValue: "examen_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione un exámen",
}

let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById('modalReg');

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => {

    if (modalOpened === false) {

        dinamicSelect2({
            // obj: examenesSeguroList,
            selectSelector: `#s-examen_id`,
            selectValue: "examen_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un exámen",
            ajax: true,
            ajaxUrl: "examenes/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.examen`);

                let selectedOptions = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-examen_id`)?.value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })

                const data1 = [];

                data?.data.forEach(object => {
                    const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                    let isDuplicate = false;

                    selectedOptions?.forEach(select => {
                        if (select == object.examen_id) {
                            isDuplicate = true;
                            return; // Salir del bucle forEach si se encuentra una duplicación
                        }
                    });

                    if (!isDuplicate) {
                        data1.push({ id: valorPropiedad1, text: nombreExamen });
                    }
                });

                // Transforms the top-level key of the response object from 'data' to 'results'
                return { results: data1 };
            }
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

    let selectSelector = `#s-examen_id${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione un exámen",
        parentModal: "#modalReg",
    })

    dinamicSelect2({
        obj: examenesSeguroList,
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: "#modalReg",
        placeholder: select2Options.placeholder,
        ajax: true,
        ajaxUrl: "examenes/consulta",
        queryPage: false,
        processResultsAjax: function (data, params) {

            const existingSelects = document.querySelectorAll(`.examen`);

            let selectedOptions = [];

            // Recorremos los select que existen
            existingSelects.forEach(select2 => {

                if (document.getElementById(`s-examen_id${clicks}`)?.value != select2.value) {
                    selectedOptions.push(select2.value);
                }
            })

            const data1 = [];

            data?.data.forEach(object => {
                const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                let isDuplicate = false;

                selectedOptions?.forEach(select => {
                    if (select == object.examen_id) {
                        isDuplicate = true;
                        return; // Salir del bucle forEach si se encuentra una duplicación
                    }
                });

                if (!isDuplicate) {
                    data1.push({ id: valorPropiedad1, text: nombreExamen });
                }
            });

            // Transforms the top-level key of the response object from 'data' to 'results'
            return { results: data1 };
        }
    });

    validateInputs();
}

window.addExamenSeguroInput = addExamenSeguroInput;