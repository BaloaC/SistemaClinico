export default function validateInputs() {
    // ** Selecciona todos los elementos input con el atributo data-validate establecido como true
    const inputs = document.querySelectorAll("input[data-validate='true']");

    // ** Define patrones de expresiones regulares para validar los campos
    const patterns = {
        username: /^[a-zA-Z0-9_-]{1,16}$/, // Patrón para nombre de usuario
        password: /^(?=.*\d)[\d\w@-]{8,20}$/i, // Patrón para contraseña
        email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/, // Patrón para email
        phone: /^\d{7}$/, // Patrón para número de teléfono
        rif: /^\d{9}$/, // Patrón para RIF
        pin: /^\d{6,}$/, // Patrón para el pin
        dni: /^\d{6,8}$/, //Patrón para la cédula
        // address: /^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/, // Patrón para dirección
        // name: /^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/, // Patrón para nombres
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
        console.log(field);
        if (regex.test(field.value)) {
            field.className = 'form-control valid';
        } else {
            field.className = 'form-control invalid';
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


