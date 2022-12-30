//hacemos el esquema de validacion para los capos que usaremos
import {addSiblingError,removeSiblingErrors, msjAlert} from "../errors.js";

const loginName=document.getElementById('login-name');
const loginPass = document.getElementById('login-pass');

const validarLogin = {
  userName: {
    presence: true,
    length: {
      minimum: 3,
      message: "El nombre del usuario tiene que ser mayor a 3",
    },
  },
  clave: {
    presence: true,
    length: {
      minimum: 6,
      message: "Error, clave mayor a 6 caracteres",
    },
  },
};
let form = document.getElementById("form-login");

form.addEventListener("submit", (e) => {
  e.preventDefault();

	let formData = new FormData(form);

  let respuesta = validate(
    {
      userName: formData.get("nombre_usuario"),
      clave: formData.get("clave"),
    },
    validarLogin,
    { fullMessages: false }
  );

	if (respuesta) {
		//se eliminan todos los errores viejos antes de añadir nuevos
        removeSiblingErrors([loginName,loginPass]);

		if (respuesta.userName) {
			//mensajeErrorLogin.innerHTML = respuesta.userName;
			//mensajeErrorClave.innerHTML = " ";
			//document.getElementById("login-name").classList.add("is-invalid");
			//document.getElementById("login-pass").classList.remove("is-invalid");

			addSiblingError(loginName, respuesta.userName[0]);
		}
		if (respuesta.clave) {

			addSiblingError(loginPass, respuesta.clave[0]);
		}

	} else {
        removeSiblingErrors([loginName,loginPass]);
		try {
			fetch("https://pokeapi.cos/api/v2/pokemon/ditto", {
				method: "GET",
				//method: "POST",
				//body: formData
			}).then(response => response.json())
				.then(data => {
					if (data.ok) {
						//si todo sale bien va por aqui
						form.reset();
					} else {
						//si la peticion es distinta a 200 - 299
						form.reset();
						msjAlert('mensaje-error','No se pudo realizar la peticion')

					}
				}).catch((error) => {
					//si no se puede realizar la peticion
					form.reset();
					//addError(document.getElementById('form-login'),'Error: no se pudo procesar la peticion')
					//setInterval(()=>{removeError(document.getElementById('manejador'))},3000)
					msjAlert('mensaje-error','No se pudo realizar la peticion')
				});

		} catch (error) {
			form.reset();
			msjAlert('mensaje-error','Error, No se puede comunicar con el servidor')


		}
	}
});
