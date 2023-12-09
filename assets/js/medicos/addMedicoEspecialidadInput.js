import dinamicSelect2, { emptyAllSelect2, emptySelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
let modalOpened = false;
let especialidades = null;
const modalRegister = document.getElementById("modalReg");
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async () => {
    if (modalOpened === false) {
        especialidades = await getAll("especialidades/consulta");

        dinamicSelect2({
            obj: especialidades,
            selectSelector: "#s-especialidad",
            selectValue: "especialidad_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una especialidad",
        });

        modalOpened = true;
    }
}



// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());
modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen());

async function addMedicoEspecialidadInput(button, parentModal = "#modalReg") {

    clicks += 1;

    let template = `
    <div class="row align-items-start newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Especialidad</label>
            <select id="s-especialidad${clicks}" data-validate="true" class="form-control ${(parentModal === "#modalReg") ? "medico-especialidad-id" : "medico-especialidad-act-id"}" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto">Costo especialidad</label>
            <input type="number" name="costo-especialidad" step="any" data-validate="true" data-type="price" class="form-control ${(parentModal === "#modalReg") ? "costo-especialidad" : "costo-especialidad-act"}"" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1">
            <button type="button" class="btn mt-4" onclick="deleteMedicoEspecialidadInput(this)"><i class="fas fa-times m-0"></i></button>
        </div>
    </div>

    `;

    document.getElementById(button).insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-especialidad${clicks}`;
    dinamicSelect2({
        obj: especialidades,
        selectSelector: `#s-especialidad${clicks}`,
        selectValue: "especialidad_id",
        selectNames: ["nombre"],
        parentModal: parentModal,
        placeholder: "Seleccione una especialidad"
    });

    // // Vacimos el select primero antes de añadirlo
    // emptyAllSelect2({
    //     selectSelector,
    //     placeholder: "Seleccione una especialidad",
    //     parentModal: parentModal,
    // })

    // const select = document.getElementById(`s-especialidad${clicks}`);
    // const optionVacio = document.createElement("option");
    // optionVacio.value = "";
    // select.insertBefore(optionVacio, select.firstChild)

    // // Se inserta la nueva información
    // dinamicSelect2({
    //     obj: especialidades,
    //     selectSelector,
    //     selectValue: "especialidad_id",
    //     selectNames: ["nombre"],
    //     parentModal: parentModal,
    //     placeholder: "Seleccione una especialidad"
    // });

    // validateExistingSelect2(parentModal, selectSelector);
    // // validateExistingSelect2OnChange(parentModal,selectSelector);

    // $(selectSelector).on("change", function () {
    //     validateExistingSelect2OnChange(parentModal, selectSelector);
    // });

    validateInputs();
}

// function validateExistingSelect2OnChange(parentModal, selectSelector) {

//     const existingSelects = document.querySelectorAll('.medico-especialidad-id');

//     existingSelects.forEach(select2 => {

//         if (selectSelector != `#${select2.id}`) {

//             // Desvincular temporalmente el manejador de eventos change
//             $(`#${select2.id}`).off('change');

//             let selectedOptions = [];

//             // Filtrar las opciones de especialidades para excluir las ya seleccionadas
//             selectedOptions = Array.from(existingSelects).map(select => {
//                 if (select.value != select2.value) {
//                     return select.value;
//                 }
//             });

//             const filteredOptions = filterOptions(especialidades, selectedOptions);

//             // Guardar el valor antes de mostrarlo
//             let selectedValue = select2.value;
            
//             emptyAllSelect2({
//                 selectSelector: `#${select2.id}`,
//                 placeholder: "Seleccione una especialidad",
//                 parentModal: parentModal,
//             });

//             dinamicSelect2({
//                 obj: filteredOptions,
//                 selectSelector: `#${select2.id}`,
//                 selectValue: "especialidad_id",
//                 selectNames: ["nombre"],
//                 parentModal: parentModal,
//                 placeholder: "Seleccione una especialidad"
//             });

//             // Cambiar el valor seleccionado a la opción guardada
//             // $(`#${select2.id}`).val(selectedValue).trigger('change');

//             // Volver a vincular el manejador de eventos change
//             // $(`#${select2.id}`).on('change', function () {
//                 // validateExistingSelect2OnChange(parentModal, selectSelector);
//             // });
//         }
//     });
// }

//     // console.log(select2.id)




//     dinamicSelect2({
//         obj: filteredOptions,
//         selectSelector: `#${select2.id}`,
//         selectValue: "especialidad_id",
//         selectNames: ["nombre"],
//         parentModal: parentModal,
//         placeholder: "Seleccione una especialidad"
//     });

//     // $(selectSelector).val(null).trigger('change');
// }

// Al añadir los inputs validar
// function validateExistingSelect2(parentModal, selectSelector) {

//     const existingSelects = document.querySelectorAll('.medico-especialidad-id');



//     existingSelects.forEach(select2 => {

//         if (selectSelector == `#${select2.id}`) {
//             emptyAllSelect2({
//                 selectSelector: `#${select2.id}`,
//                 placeholder: "Seleccione una especialidad",
//                 parentModal: parentModal,
//             })
//         }

//         let selectedOptions = [];
//         // Filtrar las opciones de especialidades para excluir las ya seleccionadas
//         selectedOptions = Array.from(existingSelects).map(select => {
//             if (select.value != select2.value) {
//                 return select.value;
//             }
//         });

//         console.log(selectedOptions);

//         const filteredOptions = filterOptions(especialidades, selectedOptions);

//         console.log(filteredOptions);

//         // Cambiar el select2 creado únicamente
//         if (selectSelector == `#${select2.id}`) {

//             // console.log(select2.id)


//             dinamicSelect2({
//                 obj: filteredOptions,
//                 selectSelector: `#${select2.id}`,
//                 selectValue: "especialidad_id",
//                 selectNames: ["nombre"],
//                 parentModal: parentModal,
//                 placeholder: "Seleccione una especialidad"
//             });

//             $(selectSelector).val(null).trigger('change');
//         } else {


//             // Guardamos el valor antes de mostrarlo
//             let selectedValue = select2.value;

//             emptyAllSelect2({
//                 selectSelector: `#${select2.id}`,
//                 placeholder: "Seleccione una especialidad",
//                 parentModal: parentModal,
//             })


//             dinamicSelect2({
//                 obj: filteredOptions,
//                 selectSelector: `#${select2.id}`,
//                 selectValue: "especialidad_id",
//                 selectNames: ["nombre"],
//                 parentModal: parentModal,
//                 placeholder: "Seleccione una especialidad"
//             });

//             console.log(select2.id, "selected", selectedValue);
//             $(`#${select2.id}`).val(selectedValue).trigger('change');
//             //     let selectedOptions = [];

//             //     // Filtrar las opciones de especialidades para excluir las ya seleccionadas
//             //     selectedOptions = Array.from(existingSelects).map(select => {
//             //         if (select.value != select2.value) {
//             //             return select.value;
//             //         }
//             //     });

//             //     console.log(selectedOptions);

//             //     const filteredOptions = filterOptions(especialidades, selectedOptions);

//             //     console.log(filteredOptions);

//             //     emptyAllSelect2({
//             //         selectSelector: `#${select2.id}`,
//             //         placeholder: "Seleccione una especialidad",
//             //         parentModal: parentModal,
//             //     })

//             //     dinamicSelect2({
//             //         obj: filteredOptions,
//             //         selectSelector: `#${select2.id}`,
//             //         selectValue: "especialidad_id",
//             //         selectNames: ["nombre"],
//             //         parentModal: parentModal,
//             //         placeholder: "Seleccione una especialidad"
//             //     });

//         }
//     })
// }

function filterOptions(options, selectedValues) {

    return options.filter(option => !selectedValues.includes(option.especialidad_id.toString()));
}

window.addMedicoEspecialidadInput = addMedicoEspecialidadInput;