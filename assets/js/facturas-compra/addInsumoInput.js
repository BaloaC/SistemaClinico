import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

const select2Options = {
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione el insumo",
    selectWidth: "100%",
}

export let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById("modalReg");

const handleModalOpen = async () => {
    if (modalOpened === false) {

        const proveedoresList = await getAll("proveedores/consulta");

        dinamicSelect2({
            obj: proveedoresList,
            selectSelector: "#s-proveedor",
            selectValue: "proveedor_id",
            selectNames: ["proveedor_id", "nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un proveedor",
            selectWidth: "100%",
        });

        dinamicSelect2({
            // obj: insumosList,
            selectSelector: "#s-insumo",
            selectValue: "insumo_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione el insumo",
            selectWidth: "100%",
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
            }
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());

function addInsumoInput() {

    const inputInsumos = document.querySelectorAll(".insumo-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputInsumos.length === 1) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector(".visible").classList.remove("d-none")
    }

    clicks += 1;
    let selectSelector = `#s-insumo${clicks}`;

    const insumoTemplate = document.getElementById("insumo-template").content;
    let clone = document.importNode(insumoTemplate, true);

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione el insumo",
        parentModal: "#modalReg",
    })

    const select = clone.getElementById("s-insumo");
    const optionVacio = document.createElement("option");

    select.id = `s-insumo${clicks}`;
    optionVacio.value = "";
    select.insertBefore(optionVacio, select.firstChild)
    clone.querySelector("tr").classList.add("newInput");
    document.getElementById("insumos-list").appendChild(clone);

    dinamicSelect2({
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: "#modalReg",
        placeholder: select2Options.placeholder,
        selectWidth: "100%",
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
        }
    });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;