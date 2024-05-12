import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
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
            selectSelector: `#s-medico-pago`,
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: parentModal,
            ajax: true,
            ajaxUrl: "medicos/consulta",
            placeholder: "Seleccione un médico",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.medico-pago-id`);

                let selectedOptions = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-medico-pago`).value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })

                const data1 = [];

                data?.data.forEach(object => {
                    const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico } = object;
                    let isDuplicate = false;

                    selectedOptions?.forEach(select => {
                        if (select == object.medico_id) {
                            isDuplicate = true;
                            return; // Salir del bucle forEach si se encuentra una duplicación
                        }
                    });

                    if (!isDuplicate) {
                        data1.push({ id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` });
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


function addMedicoPagoInput(parentModal = "#modalReg") {

    clicks += 1;
    let template = `

    <div class="row align-items-start newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Médico</label>
            <select id="s-medico-pago${clicks}" class="form-control medico-pago-id" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto" class="">Monto</label>
            <input type="number" step="any" data-validate="true" data-type="price" class="form-control monto-pago" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1 pt-4-5">
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
        placeholder: select2Options.placeholder,
        ajax: true,
        ajaxUrl: "medicos/consulta",
        placeholder: "Seleccione un médico",
        queryPage: false,
        processResultsAjax: function (data, params) {

            const existingSelects = document.querySelectorAll(`.medico-pago-id`);

            let selectedOptions = [];

            // Recorremos los select que existen
            existingSelects.forEach(select2 => {
                if (document.getElementById(`s-medico-pago${clicks}`).value != select2.value) {
                    selectedOptions.push(select2.value);
                }
            })

            const data1 = [];

            data?.data.forEach(object => {
                const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico } = object;
                let isDuplicate = false;

                selectedOptions?.forEach(select => {
                    if (select == object.medico_id) {
                        isDuplicate = true;
                        return; // Salir del bucle forEach si se encuentra una duplicación
                    }
                });

                if (!isDuplicate) {
                    data1.push({ id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` });
                }
            });

            // Transforms the top-level key of the response object from 'data' to 'results'
            return { results: data1 };
        }
    });

    validateInputs();
}

window.addMedicoPagoInput = addMedicoPagoInput;