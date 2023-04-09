import getAll from "../global/getAll.js";
import questions from "../global/questions.js";
const path = location.pathname.split('/')

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
            <div class="text-center mt-3"><button type="submit" id="btnEnviar" class="btn btn-primary w-50" value="${infoUser[0].usuario_id}">Enviar</button></div>
        </div>
    `;

    // Template para la opción 1
    let templatePin = `
        <div>
            <label for="pin" class="mt-3">Pin de Seguridad</label>
            <input class="form-control" type="text" name="pin" placeholder="Introduzca el pin de seguridad de seguridad de 6 dígitos" required>
            <label for="nueva_clave" class="mt-3">Nueva clave</label>
            <input class="form-control" type="password" name="nueva_clave" placeholder="Nueva clave" required>
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
    })
}

document.getElementById("siguiente").addEventListener("click", async (event) => {

    const $alert = document.querySelector(".alert");

    try {

        const nombreUsuario = document.getElementById("usuario").value;
        
        let formDataUsuario = new FormData();
        formDataUsuario.append('nombre_usuario', nombreUsuario);
        
        for(let [name, value] of formDataUsuario) {
            alert(`${name} = ${value}`); // key1 = value1, luego key2 = value2
        }

        const options = {
            body: JSON.stringify(formDataUsuario),
        };
            usuarioResponse = await fetch(`/${path[1]}/preguntas/usuario`, options);
            // usuarioResponse = await getAll(`preguntas/usuario`, options);
            console.log('usuario',usuarioResponse)
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

document.getElementById("login-form").addEventListener("submit", async (event) => {

    event.preventDefault();
    
        $alert = document.querySelector(".alert"),
        $btnEnviar = document.getElementById("btnEnviar");

    try {

        const formData = new FormData(event.target),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify({
                tipo_auth: data.metodo,
                auth: data.pin,
                nueva_clave: data.nueva_clave
            }),
        };

        const response = await fetch(`/${path[1]}/login/${$btnEnviar.value}`, options),
        json = await response.json();

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


