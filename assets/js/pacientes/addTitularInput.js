import { defaultSelect } from "../global/defaultSelect.js";
import dinamicSelect2, { emptyAllSelect2, emptySelect2 } from "../global/dinamicSelect2.js";
import validateExistingSelect2 from "../global/validateExistingSelect2.js";
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js";
import getTitulares from "./getTitulares.js";

export let titularesList = null;
const select2Options = {
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    placeholder: "Seleccione un titular",
}

let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById('modalReg');
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async (parentModal) => {

    if (modalOpened === false) {

        // titularesList = await getTitulares();

        let selectSelectorTitular = parentModal === "#modalReg" ? "#s-titular_id" : "#s-titular_id-act";
        let selectSelectorTipoRelacion = parentModal === "#modalReg" ? "#tipo_relacion" : "#tipo_relacion-act";


        $(selectSelectorTipoRelacion).on("change", function () {


            document.getElementById("s-titular_id").disabled = false;
            $(selectSelectorTitular).empty().select2();

            dinamicSelect2({
                // obj: titularesList,
                selectSelector: selectSelectorTitular,
                selectValue: "paciente_id",
                selectNames: ["cedula", "nombre-apellidos"],
                parentModal: parentModal,
                placeholder: "Seleccione un titular",
                ajax: true,
                ajaxUrl: `pacientes/consulta?tipo_paciente=${this.value === "1" ? "3" : "2"}`,
                queryPage: false,
                processResultsAjax: function (data, params) {

                    const existingSelects = document.querySelectorAll(`.titular`);
    
                    let selectedOptions = [];
                    const data1 = [];
    
                    // Recorremos los select que existen
                    existingSelects.forEach(select2 => {
                        if (document.getElementById(`s-titular_id`).value != select2.value) {
                            selectedOptions.push(select2.value);
                        }
                    })
    
    
                    if (typeof data === "object" && data?.data !== 0) {
    
                        data?.data?.forEach(object => {
    
                            const { paciente_id: valorPropiedad1, cedula, nombre, apellidos, tipo_paciente } = object;
                            let isDuplicate = false;
    
                            selectedOptions?.forEach(select => {
                                if (select == object.paciente_id) {
                                    isDuplicate = true;
                                    return; // Salir del bucle forEach si se encuentra una duplicación
                                }
                            });
    
                            const handleTipoPaciente = (tipo_paciente) => {
                                if (tipo_paciente == 1) tipo_paciente = "Natural";
                                else if (tipo_paciente == 2) tipo_paciente = "Representante";
                                else if (tipo_paciente == 3) tipo_paciente = "Asegurado";
                                else if (tipo_paciente == 4) tipo_paciente = "Beneficiado";
    
                                return tipo_paciente
                            }
    
                            if (!isDuplicate) {
                                data1.push({ id: valorPropiedad1, text: `${cedula} - ${nombre} ${apellidos} - ${handleTipoPaciente(tipo_paciente)}` });
                            }
                        });
    
                    }
    
                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1 ?? []
                    };
                }
            });
        })

        modalOpened = true;
    }
}
// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalAct"));

async function addTitularInput() {

    const inputTitulares = document.querySelectorAll(".titular");

    // Validamos que exista un solo titular para poder añadirle que se pueda eliminar
    if (inputTitulares.length === 1) {
        document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <hr>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Tipo de relación</label>
                <select name="tipo_relacion" id="tipo_relacion${clicks}" class="form-control mb-3 default-select relacion" required>
                    <option value="" disabled selected>Seleccione el tipo de relación</option>
                    <option value="1">Seguro</option>
                    <option value="2">Natural</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="titular">Titular</label>
                <select name="titular_id" id="s-titular_id${clicks}" class="form-control mb-3 titular" data-active="0" required>
                    <option value="" selected>Seleccione un titular</option>
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

    let selectSelector = `#s-titular_id${clicks}`;
    let selectSelectorTipoRelacion = `#tipo_relacion${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione la relación",
        parentModal: "#modalReg",
    })

    document.getElementById(selectSelector.replace("#","")).disabled = true;
    
    
    $(selectSelectorTipoRelacion).on("change", function () {
        
        document.getElementById(selectSelector.replace("#","")).disabled = false;
        $(selectSelector).empty().select2();

        dinamicSelect2({
            // obj: titularesList,
            selectSelector,
            selectValue: select2Options.selectValue,
            selectNames: select2Options.selectNames,
            parentModal: "#modalReg",
            placeholder: select2Options.placeholder,
            ajax: true,
            ajaxUrl: `pacientes/consulta?tipo_paciente=${this.value === "1" ? "3" : "2"}`,
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.titular`);

                let selectedOptions = [];
                const data1 = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-titular_id${clicks}`).value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })


                if (typeof data === "object" && data?.data !== 0) {

                    data?.data?.forEach(object => {

                        const { paciente_id: valorPropiedad1, cedula, nombre, apellidos, tipo_paciente } = object;
                        let isDuplicate = false;

                        selectedOptions?.forEach(select => {
                            if (select == object.paciente_id) {
                                isDuplicate = true;
                                return; // Salir del bucle forEach si se encuentra una duplicación
                            }
                        });

                        const handleTipoPaciente = (tipo_paciente) => {
                            if (tipo_paciente == 1) tipo_paciente = "Natural";
                            else if (tipo_paciente == 2) tipo_paciente = "Representante";
                            else if (tipo_paciente == 3) tipo_paciente = "Asegurado";
                            else if (tipo_paciente == 4) tipo_paciente = "Beneficiado";

                            return tipo_paciente
                        }

                        if (!isDuplicate) {
                            data1.push({ id: valorPropiedad1, text: `${cedula} - ${nombre} ${apellidos} - ${handleTipoPaciente(tipo_paciente)}` });
                        }
                    });

                }

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1 ?? []
                };
            }
        });

    })


    defaultSelect();
}

window.addTitularInput = addTitularInput;