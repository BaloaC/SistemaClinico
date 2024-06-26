function cleanForm(form) {
    Array.from(document.getElementById(form)?.elements)?.forEach(element => {

        if (element.nodeName === "SELECT") {

            $(element).val([]).change();
            element.classList.add("default-select");

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

        element.classList.remove("valid");
        element.classList.remove("invalid");
        element.classList.remove("is-invalid");
        element.classList.remove("is-valid");
    })
}

window.cleanForm = cleanForm;