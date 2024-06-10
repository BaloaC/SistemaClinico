function cleanForm(form) {
    Array.from(document.getElementById(form)?.elements)?.forEach(element => {

        if (element.nodeName === "SELECT") {

            $(element).val([]).change();

        } else if (element.nodeName === "INPUT") {

            if (element.type === "checkbox") {
                element.checked = false;
                element.dispatchEvent(new Event("change"));
            } else {

                document.getElementById(form).reset();
            }

        } else if (element.nodeName === "TEXTAREA") {
            document.getElementById(form).reset();
        }

    })
}

window.cleanForm = cleanForm;