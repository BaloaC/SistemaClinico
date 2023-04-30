import getAll from "./getAll.js";

export function selectText(selectTexts, obj) {
    let text = "";
    selectTexts.forEach(el => {
        let combinedText;

        if (el.includes("-")) {
            let keys = el.split("-");
            combinedText = `${obj[keys[0]].split(" ")[0]} ${obj[keys[1]].split(" ")[0]}`;
        }
        text += `${combinedText || obj[el]} - `;
    });
    return text.slice(0, -3);
}

export default function dinamicSelect2({ obj = null, selectNames = null, selectValue = null, selectSelector = null, placeholder = null, parentModal = null, selectWidth = "45%", staticSelect = false }) {
    try {
        const selectObj = [];

        console.log(obj);

        if (!staticSelect) {
            obj.forEach(el => {
                let option = {
                    id: el[selectValue],
                    text: selectText(selectNames, el)
                }
                selectObj.push(option);
            });
        }

        $(selectSelector).select2({
            width: selectWidth,
            data: (selectObj.length === 0) ? obj : selectObj,
            placeholder,
            theme: "bootstrap-5",
            language: "es",
            dropdownParent: $(parentModal)
        })
    } catch (error) {
        console.log(error);
    }
}

export async function select2OnClick({ selectSelector, module, selectValue, selectNames, placeholder = null, selectWidth = "45%", parentModal = null, multiple = false }) {

    // ** Crear select en caso de que no exista
    if (!document.querySelector(selectSelector).classList.contains("select2-hidden-accessible")) {

        const options = {
            width: selectWidth,
            placeholder,
            theme: "bootstrap-5",
            language: "es",
            scrollAfterSelect: multiple,
            closeOnSelect: !multiple,
            dropdownParent: $(parentModal),
            allowClear: multiple
        }

        if (parentModal === null) {
            delete options.dropdownParent;
        }

        $(selectSelector).select2(options);
    }

    $(selectSelector).on("select2:open", async function (e) {

        if (document.querySelector(selectSelector).dataset.active == 0) {

            const obj = await getAll(module);

            obj.forEach(el => {
                if ($(selectSelector).find(`option[value="${el[selectValue]}"]`).length) {
                    $(selectSelector).val(el[selectValue]);
                } else {
                    let newOption = new Option(selectText(selectNames, el), el[selectValue], false, false);
                    $(selectSelector).append(newOption);
                }
            });

            $(selectSelector).val(0).trigger('change.select2');
            $(selectSelector).select2("close");
            document.querySelector(selectSelector).dataset.active = 1;
        }

        $(selectSelector).select2("open");
    })

    // console.log(parentModal);
    if (parentModal !== null) {
        document.querySelector(parentModal).addEventListener("hidden.bs.modal", e => {
            document.querySelector(selectSelector).dataset.active = 0;
        })
    }
}

export function emptySelect2({ selectSelector, selectWidth = "45%", placeholder, parentModal, disabled = false }) {

    $(selectSelector).select2({
        width: selectWidth,
        placeholder,
        theme: "bootstrap-5",
        language: "es",
        dropdownParent: $(parentModal),
        disabled
    })
}

export function insertOptionSelect2({ selectSelector, text, id }) {

    let newOption = new Option(text, id, true, true);
    $(selectSelector).append(newOption).trigger('change');
}

export function createOptionOrSelectInstead({ obj, selectSelector, selectValue, selectNames }) {

    if ($(selectSelector).find(`option[value="${obj[selectValue]}"]`).length) {
        $(selectSelector).val(obj[selectValue]).trigger('change');
    } else {
        let newOption = new Option(selectText(selectNames, obj), obj[selectValue], true, true);
        $(selectSelector).append(newOption).trigger('change');
    }
}
