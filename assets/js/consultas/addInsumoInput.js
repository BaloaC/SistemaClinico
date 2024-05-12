import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import validateInputs from "../global/validateInputs.js";

export let insumosList = null;
const select2Options = {
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione el insumo"
}

let clicks = 0;
let modalOpened = false;
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async (parentModal) => {
    if (modalOpened === false) {

        insumosList = await getAll("insumos/consulta");

        dinamicSelect2({
            selectSelector: `#s-insumo`,
            selectValue: "insumo_id",
            selectNames: ["nombre"],
            parentModal: parentModal,
            placeholder: "Seleccione el insumo",
            ajax: true,
            ajaxUrl: "insumos/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const existingSelects = document.querySelectorAll(`.insumo-id`);

                let selectedOptions = [];

                // Recorremos los select que existen
                existingSelects.forEach(select2 => {
                    if (document.getElementById(`s-insumo`).value != select2.value) {
                        selectedOptions.push(select2.value);
                    }
                })

                const data1 = [];

                data?.data.forEach(object => {
                    const { insumo_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                    let isDuplicate = false;

                    selectedOptions?.forEach(select => {
                        if (select == object.insumo_id) {
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
            },
            querys: function (params) {
                const query = {
                    search: params.term,
                    select: true,
                    agotado: false
                }

                // Query parameters will be ?search=[term]&page=[page]
                return query;
            }
        });

        $("#s-insumo").on("change", async function() {

            let insumo_id = this.value;
            const insumo = await getById("insumos",insumo_id);
    
            let mensaje = "";
            
            switch(insumo.tipo_medida){
                case "1": mensaje = "La capacidad es por metro"; break;
                case "2": mensaje = "La capacidad es por mililitro"; break;
                case "3": mensaje = "La capacidad de la caja son unidades"; break;
                case "4": mensaje = "La capacidad es por unidades"; break;
            }
    
            document.querySelector(`.mensaje-medida`).innerText = mensaje;
        });
    

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
if (modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegConsulta"));

function addInsumoInput(parentModal = "#modalReg") {


    const inputInsumos = document.querySelectorAll(".insumo-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputInsumos.length === 1) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector("div:nth-child(2)").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-start newInput">
            <div class="col-12 col-md-5">
                <label for="insumo">Insumo</label>
                <select name="insumo_id" id="s-insumo${clicks}" class="form-control insumo-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="cantidad">Cantidad utilizada</label>
                <input type="number" step="any" name="cantidad" data-validate="true" data-type="number" class="form-control insumo-cant">
                <small class="form-text col-12">Solo se permiten números</small>
                <small class="text-secondary mensaje-medida${clicks}"></small>
            </div>
            <div class="col-3 col-md-1 pt-4-5">
                <button type="button" class="btn" onclick="deleteInput(this,'.insumo-id', '${parentModal}')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addInsumo").insertAdjacentHTML("beforebegin", template);


    let selectSelector = `#s-insumo${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: select2Options.placeholder,
        parentModal,
    })

    dinamicSelect2({
        obj: insumosList,
        selectSelector: selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal,
        placeholder: select2Options.placeholder,
        ajax: true,
        ajaxUrl: "insumos/consulta",
        queryPage: false,
        processResultsAjax: function (data, params) {

            const existingSelects = document.querySelectorAll(`.insumo-id`);

            let selectedOptions = [];

            // Recorremos los select que existen
            existingSelects.forEach(select2 => {
                if (document.getElementById(`s-insumo${clicks}`).value != select2.value) {
                    selectedOptions.push(select2.value);
                }
            })

            const data1 = [];

            data?.data.forEach(object => {
                const { insumo_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                let isDuplicate = false;

                selectedOptions?.forEach(select => {
                    if (select == object.insumo_id) {
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
        },
        querys: function (params) {
            const query = {
                search: params.term,
                select: true,
                agotado: false
            }

            // Query parameters will be ?search=[term]&page=[page]
            return query;
        }
    });

    // Al cambiar de insumo que muestre su tipo de capacidad
    $(selectSelector).on("change", async function() {

        let insumo_id = this.value;
        const insumo = await getById("insumos",insumo_id);

        let mensaje = "";
        
        switch(insumo.tipo_medida){
            case "1": mensaje = "La capacidad es por metro"; break;
            case "2": mensaje = "La capacidad es por mililitro"; break;
            case "3": mensaje = "La capacidad de la caja son unidades"; break;
            case "4": mensaje = "La capacidad es por unidades"; break;
        }

        document.querySelector(`.mensaje-medida${clicks}`).innerText = mensaje;
    });


    validateInputs();
}

window.addInsumoInput = addInsumoInput;