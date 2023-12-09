import { patterns } from "./patternsValidation.js";

export default function validateInputs() {
    // ** Selecciona todos los elementos input con el atributo data-validate establecido como true
    const inputs = document.querySelectorAll("input[data-validate='true']");
    
    // ** Agregar eventos a cada elemento input
    inputs.forEach((input) => {

        // ** Agregar evento change en caso de que sea de tipo time
        if(input.dataset.type === "time" || input.dataset.type === "timeAppointment" || input.dataset.type === "date"){
            input.addEventListener('change', (e) => {
                validate(e.target, patterns[e.target.dataset.type]);
            });
        }
    
        // ** Agregar evento 'keyup' para validar el campo en cada cambio
        input.addEventListener('keyup', (e) => {
            validate(e.target, patterns[e.target.dataset.type]);
        });

        // ** Agregar evento 'input' para limitar la longitud del campo
        input.addEventListener("input", (e) => {
            if (input.value.length > e.target.dataset.maxLength) {
                input.value = input.value.substring(0, e.target.dataset.maxLength);
            }
        })
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

    // ** Seleccionar los elementos de contraseña y confirmación
    const password = document.querySelector("input[name='clave']");
    const confirmPassword = document.querySelector("input[name='confirmarClave']");


    if (password && confirmPassword) {

        // ** Crear una función para validar la contraseña y la confirmación
        function validatePassword() {
            if (confirmPassword.value !== '' && confirmPassword.value === password.value) {
                confirmPassword.className = 'form-control valid';
            } else {
                confirmPassword.className = 'form-control invalid';
            }
        }

        // ** Agregar evento 'blur' e 'input' a los campos de contraseña y confirmación
        password.addEventListener('blur', validatePassword);
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('blur', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    }
}
validateInputs();


