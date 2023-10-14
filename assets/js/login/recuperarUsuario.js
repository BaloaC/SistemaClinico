import getAll from "../global/getAll.js";
import questions from "../global/questions.js";
import validateInputs from "../global/validateInputs.js";
function template(infoUser) {
    console.log(infoUser);
    // Template para la opción 2
    let templatePreguntas = `
        <div>
            <label for="respuesta1" class="mt-3">${questions(infoUser[0].pregunta)}</label>
            <input class="form-control" type="text" name="respuesta1" placeholder="Introduce la respuesta a la pregunta de seguridad" required>
            <label for="respuesta2" class="mt-3">${questions(infoUser[1].pregunta)}</label>
            <input class="form-control" type="text" name="respuesta2" placeholder="Introduce la respuesta a la pregunta de seguridad"  required>
            <label for="respuesta2" class="mt-3">${questions(infoUser[2].pregunta)}</label>
            <input class="form-control" type="text" name="respuesta3" placeholder="Introduce la respuesta a la pregunta de seguridad" required>
            <label for="nueva_clave" class="mt-3">Nueva clave</label>
            <input class="form-control" type="password" name="clave" placeholder="Introduzca su nueva clave" data-validate="true" data-type="password" data-max-length="20" required>
            <small class="form-text">- La contraseña debe contener al menos 8 caracteres y un número <br> - Los caracteres permitdos son: "@" y "-"</small>
            <label for="confirmar_nueva_clave" class="mt-3">Confirmar nueva clave</label>
            <input class="form-control" type="password" name="confirmarClave" placeholder="Confirme su nueva clave" data-max-length="20" required>
            <small class="form-text">Las contraseñas no coinciden</small>
            <input type="hidden" name="pregunta1" value="${infoUser[0].pregunta}">
            <input type="hidden" name="pregunta2" value="${infoUser[1].pregunta}">
            <input type="hidden" name="pregunta3" value="${infoUser[2].pregunta}">
            <input type="hidden" name="usuario_id" value="${infoUser[0].usuario_id}">
            <div class="text-center mt-3"><button type="submit" id="btnEnviar" class="btn btn-primary w-50" value="${infoUser[0].usuario_id}">Enviar</button></div>
        </div>
    `;

    // Template para la opción 1
    let templatePin = `
        <div>
            <label for="pin" class="mt-3">Pin de Seguridad</label>
            <input class="form-control" type="text" name="pin" placeholder="Introduzca el pin de seguridad de seguridad de 6 dígitos" required>
            <label for="nueva_clave" class="mt-3">Nueva clave</label>
            <input class="form-control" type="password" name="clave" placeholder="Introduzca su nueva clave" data-validate="true" data-type="password" data-max-length="20" required>
            <small class="form-text">La contraseña debe contener al menos 8 caracteres y un número <br> y los caracteres permitdos son: "@" y "-"</small>
            <label for="confirmar_nueva_clave" class="mt-3">Confirmar nueva clave</label>
            <input class="form-control" type="password" name="confirmarClave" placeholder="Confirme su nueva clave" required>
            <small class="form-text">Las contraseñas no coinciden</small>
            <div class="text-center mt-3"><button type="submit" id="btnEnviar" class="btn btn-primary w-50" value="${infoUser[0].usuario_id}">Enviar</button></div>
        </div>
    `

    let childForm = document.getElementById('childForm');
    let selectOpcion = document.getElementById("select-metodo");

    selectOpcion.addEventListener('change', (event) => {

        if (selectOpcion.value == 2) {
            // Verificamos si ya hay un template agregado
            if (childForm.hasChildNodes()) {
                $($(childForm).children()).replaceWith(templatePreguntas);

            } else {
                //Si no lo hay entonces lo agregamos normal, sin reemplzar nada
                $(childForm).append(templatePreguntas);
            }

        } else if (selectOpcion.value == 1) {
            if (childForm.hasChildNodes()) {
                $($(childForm).children()).replaceWith(templatePin);

            } else {
                $(childForm).append(templatePin);

            }
        }

        validateInputs();
    })
}

document.getElementById("siguiente").addEventListener("click", async (event) => {

    const $alert = document.querySelector(".alert");

    try {

        const nombreUsuario = document.getElementById("usuario"),
            usuarioResponse = await getAll(`preguntas/usuario?usuario=${nombreUsuario.value}`);

        if (usuarioResponse === undefined) throw { message: "El usuario no es valido o no existe" };


        template(usuarioResponse);

        const formUser = document.getElementById("form-user"),
            formRecovery = document.getElementById("form-recovery");

        formUser.classList.toggle("op-0");
        setTimeout(() => {
            formUser.classList.toggle("d-none");
            formRecovery.classList.add("form-centrar");
        }, 500);

    } catch (error) {

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = `${error.message}`;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3500);
    }
})

const input = document.getElementById('usuario');

input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});

document.getElementById("login-form").addEventListener("submit", async (event) => {

    event.preventDefault();
    const path = location.pathname.split('/'),
        $alert = document.querySelector(".alert"),
        $btnEnviar = document.getElementById("btnEnviar");

    try {

        const formData = new FormData(event.target),
            data = {};

        let json;

        formData.forEach((value, key) => (data[key] = value));

        if (!event.target.checkValidity()) { event.target.reportValidity(); return; }
        if (data.clave !== data.confirmarClave) throw { message: "Las contraseñas no coinciden" };
        if (!((/^(?=.*\d)[\d\w@-]{8,20}$/i).test(data.clave))) throw { message: "Contraseña inválida" };
        if (!((/^(?=.*\d)[\d\w@-]{8,20}$/i).test(data.confirmarClave))) throw { message: "Contraseña inválida" };

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },

        };

        if (data.metodo == 1) {
            options.body = JSON.stringify({
                tipo_auth: data.metodo,
                auth: data.pin,
                nueva_clave: data.clave
            })

            const response = await fetch(`/${path[1]}/login/${$btnEnviar.value}`, options);
            json = await response.json();

        } else {

            const preguntas = [
                {
                    pregunta: data.pregunta1,
                    respuesta: data.respuesta1
                }, {
                    pregunta: data.pregunta2,
                    respuesta: data.respuesta2
                }, {
                    pregunta: data.pregunta3,
                    respuesta: data.respuesta3
                }
            ]

            options.body = JSON.stringify({
                nombre: data.usuario,
                usuario_id: data.usuario_id,
                nueva_clave: data.clave,
                preguntas: preguntas
            })

            const response = await fetch(`/${path[1]}/respuesta/${$btnEnviar.value}`, options);
            json = await response.json();
        }



        if (!json.code) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = "Clave recuperada exitosamente!";

        setTimeout(() => {
            location.assign(`/${path[1]}/login`);
        }, 500);


    } catch (error) {

        let message = error.message || error.result.message;

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = `${message}`;
    }
})


