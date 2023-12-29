import dinamicSelect2, { emptyAllSelect2 } from "./dinamicSelect2.js";
import filterOptionsSelect2  from "./filterOptionsSelect2.js";

export default function validateExistingSelect2({ parentModal, selectSelector, selectClass, addButtonId, objList, optionId, select2Options }) {

    const existingSelects = document.querySelectorAll(`.${selectClass}`);

    if (objList.length <= existingSelects.length) {
        $(addButtonId).fadeOut("slow");
    }

    existingSelects.forEach(select2 => {

        if (selectSelector == `#${select2.id}`) {
            emptyAllSelect2({
                selectSelector: `#${select2.id}`,
                placeholder: select2Options.placeholder,
                parentModal: parentModal,
            })
        }

        let selectedOptions = [];
        // Filtrar las opciones de especialidades para excluir las ya seleccionadas
        selectedOptions = Array.from(existingSelects).map(select => {
            if (select.value != select2.value) {
                return select.value;
            }
        });

        const filteredOptions = filterOptionsSelect2({ options: objList, selectedValues: selectedOptions, optionId });

        // Cambiar el select2 creado únicamente
        if (selectSelector == `#${select2.id}`) {

            dinamicSelect2({
                obj: filteredOptions,
                selectSelector: `#${select2.id}`,
                selectValue: select2Options.selectValue,
                selectNames: select2Options.selectNames,
                parentModal: parentModal,
                placeholder: select2Options.placeholder
            });

            $(selectSelector).val(null).trigger('change');

        }
    })
}