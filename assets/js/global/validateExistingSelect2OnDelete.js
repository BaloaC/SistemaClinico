import dinamicSelect2, { emptyAllSelect2 } from "./dinamicSelect2.js";
import filterOptionsSelect2 from "./filterOptionsSelect2.js";
import validateExistingSelect2OnChange from "./validateExistingSelect2OnChange.js";

export default function validateExistingSelect2OnDelete({ parentModal, selectClass, objList, optionId, addButtonId, select2Options }) {

    const existingSelects = document.querySelectorAll(`.${selectClass}`);

    try {

        if (existingSelects.length <= objList.length) {
            $(addButtonId).fadeIn("slow");
        }

        existingSelects.forEach(select2 => {

            // Desvincular temporalmente el manejador de eventos change
            $(`#${select2.id}`).off('change');

            let selectedOptions = [];

            // Filtrar las opciones de especialidades para excluir las ya seleccionadas
            selectedOptions = Array.from(existingSelects).map(select => {
                if (select.value != select2.value) {
                    return select.value;
                }
            });

            const filteredOptions = filterOptionsSelect2({ options: objList, selectedValues: selectedOptions, optionId });

            // Guardar el valor antes de mostrarlo
            let selectedValue = select2.value;

            emptyAllSelect2({
                selectSelector: `#${select2.id}`,
                placeholder: select2Options.placeholder,
                parentModal: parentModal,
            });

            dinamicSelect2({
                obj: filteredOptions,
                selectSelector: `#${select2.id}`,
                selectValue: select2Options.selectValue,
                selectNames: select2Options.selectNames,
                parentModal: parentModal,
                placeholder: select2Options.placeholder
            });
            
            // Cambiar el valor seleccionado a la opción guardada
            $(`#${select2.id}`).val(selectedValue).trigger('change');
            !selectedValue && document.getElementById(select2.id).classList.remove("is-valid");

            // Volver a vincular el manejador de eventos change
            $(`#${select2.id}`).on('change', function () {
                validateExistingSelect2OnChange({
                    parentModal,
                    selectSelector: `#${select2.id}`,
                    selectClass,
                    objList,
                    select2Options,
                    optionId
                });
                
                selectedValue && document.getElementById(select2.id).classList.remove("is-valid");
            });

        });

    } catch (error) {
        console.log(error);
    }
}
