import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";

const path = location.pathname.split('/');

async function addUsuario() {
    const $form = document.getElementById("info-usuario"),
    $alert = document.querySelector(".alert");

    try {

        const formData = new FormData($form),
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
                pregunta: data.pregunta3,
                respuesta: data.respuesta3
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


        const registroExitoso = await addModule("usuarios", "info-usuario", data, "Usuario registrado con exito!");
       
        if (!registroExitoso.code) throw { result: registroExitoso.result };

        cleanValdiation("info-usuario");
        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = "Usuario registrado correctamente!";
        $('#usuariosTable').DataTable().ajax.reload();

    } catch (error) {

        let message = error.message || error.result.message;

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = `${message}`;
    }
}

window.addUsuario = addUsuario;