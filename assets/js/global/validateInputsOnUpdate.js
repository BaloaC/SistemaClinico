import { patterns } from "./patternsValidation.js";

export default function validateInputsOnUpdate() {
    // ** Selecciona todos los elementos input con el atributo data-validate establecido como true
    const inputs = document.querySelectorAll("input[data-validate='true']");

    // ** Agregar eventos a cada elemento input
    inputs.forEach((input) => {
    
        // ** Agregar evento 'keyup' para validar el campo en cada cambio
        validate(input, patterns[input.dataset.type]);
    });

    // ** Validar si el valor del campo coincide con el patrón correspondiente
    function validate(field, regex) {
        if (regex.test(field.value)) {
            field.classList.remove("invalid");
            field.classList.add("valid");
        } else {
            field.classList.remove("valid");
            field.classList.add("invalid");
        }
    }
}