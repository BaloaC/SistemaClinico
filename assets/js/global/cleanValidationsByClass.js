export default function cleanValdiationByClass(elementId){ 

    const forms = document.querySelectorAll(elementId);

    forms.forEach((form) => {
        Array.from(form.elements).forEach((element) => {
            element.classList.remove("valid");
            element.classList.remove('invalid');
            element.classList.remove('is-invalid');
            element.classList.remove('is-valid');
        });
    });
}

