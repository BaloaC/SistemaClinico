// ** Selecciona todos los elementos input con el atributo data-validate establecido como true
const inputs = document.querySelectorAll("input[data-validate='true']");

// ** Define patrones de expresiones regulares para validar los campos
const patterns = {
    username: /^[a-zA-Z0-9_-]{1,16}$/, // Patrón para nombre de usuario
    password: /^[\d\w@-]{4,20}$/i, // Patrón para contraseña
    email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/, // Patrón para email
    phone: /^\d{7}$/, // Patrón para número de teléfono
    rif: /^\d{9}$/, // Patrón para RIF
    pin: /^\d{6,}$/, // Patrón para el pin
    dni: /^\d{6,8}$/, //Patrón para la cédula
    address: /^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/, // Patrón para dirección
    name: /^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/, // Patrón para nombres
    number: /^[1-9]\d*$/, // Patrón para validar inputs tipo number
    price: /^[0-9]*\.?[0-9]+$/ // Patrón para los precios
};

// ** Agregar eventos a cada elemento input
inputs.forEach((input) => {
    // ** Agregar evento 'keyup' para validar el campo en cada cambio
    // input.addEventListener('keyup', (e) => {
    //     validate(e.target, patterns[e.target.dataset.type]);
    // });

    // ** Agregar evento 'blur' para validar el campo cuando pierde el foco
    input.addEventListener('blur', (e) => {
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
        field.className = 'form-control valid';
    } else {
        field.className = 'form-control invalid';
    }
}

// ** Seleccionar los elementos de contraseña y confirmación
const password = document.querySelector("input[name='clave']");
const confirmPassword = document.querySelector("input[name='confirmarClave']");

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


// function validatePassword(field, regex, confirmRegex) {
//     const passwordField = document.getElementById('password');
//     const confirmPasswordField = document.getElementById('password-confirm');

//     if (regex.test(passwordField.value) && confirmRegex.test(confirmPasswordField.value) && passwordField.value === confirmPasswordField.value) {
//         passwordField.className = 'form-control valid';
//         confirmPasswordField.className = 'form-control valid';
//     } else {
//         passwordField.className = 'form-control invalid';
//         confirmPasswordField.className = 'form-control invalid';
//     }
// }

// document.getElementById('password').addEventListener("blur", e => {
//     validatePassword(e.target, patterns[e.target.dataset.type])
// })






