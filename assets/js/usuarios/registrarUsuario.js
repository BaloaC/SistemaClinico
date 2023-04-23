const path = location.pathname.split('/');

// ** Función para validar si todos los inputs están validados antes de dar siguiente
function nextValidate(form, inputsNumber) {
    const inputsValidate = document.querySelectorAll(`${form} .form-control.valid`);
    if (inputsValidate.length === inputsNumber) return true
    else return false;
}

// ** Animación
document.getElementById("siguiente").addEventListener("click", (event) => {

    formInfo = document.getElementById("form-info");
    formPreguntas = document.getElementById("form-preguntas");
    if (!nextValidate(".form-info", 4)) return;

    formInfo.classList.toggle("op-0");
    setTimeout(() => {
        formPreguntas.classList.add("form-centrar");
    }, 500);
})

document.addEventListener("submit", async e => {

    e.preventDefault();
    const $alert = document.querySelector(".alert");

    try {

        const formData = new FormData(e.target),
            $form = e.target;
        data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (data.clave !== data.confirmarClave) throw { message: "Las contraseñas no coinciden" };
        if (!((/^[a-zA-Z0-9_-]{1,16}$/).test(data.nombre))) throw { message: "Nombre de usuario inválido" };
        if (!((/^(?=.*\d)[\d\w@-]{8,20}$/i).test(data.clave))) throw { message: "Contraseña inválida" };
        if (!((/^(?=.*\d)[\d\w@-]{8,20}$/i).test(data.confirmarClave))) throw { message: "Contraseña inválida" };
        if (!((/^\d{6,}$/).test(data.pin))) throw { message: "Pin inválido" };
        if (!(data.rol > 0 && data.rol <= 5)) throw { message: "Nivel de usuario inválido" };


        const preguntas = [
            {
                pregunta: data.pregunta1,
                respuesta: data.respuesta1
            },
            {
                pregunta: data.pregunta2,
                respuesta: data.respuesta2
            },
            {
                pregunta: data.pregunta2,
                respuesta: data.respuesta2
            }
        ];
        data.preguntas = preguntas;


        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(data),
        };

        const response = await fetch(`/${path[1]}/usuarios`, options);

        json = await response.json();

        if (!json.code) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = "Usuario registrado correctamente!";
        // location.assign(`/${path[1]}/login`);


    } catch (error) {

        let message = error.message || error.result.message;

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = `${message}`;
    }
});
