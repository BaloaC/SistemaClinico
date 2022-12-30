import {addSiblingError,removeSiblingErrors,msjAlert} from "../../errors.js";

const claveVieja = document.getElementById('claveVieja');
const claveNueva = document.getElementById('claveNueva');

const validarClave = {
	claveVieja: {
		presence: true,
		length: {
			minimum: 7,
			message: "la clave tiene que ser mayor a 6 caracteres",
		},
	},
	claveNueva: {
		presence: true,
		length: {
			minimum: 7,
			message: "La nueva contraseña tiene que ser mas larga",
		},
		equality: {
			attribute: "claveRepetida",
			message: "No coinciden las claves",
			comparator: function (v1, v2) {
				return JSON.stringify(v1) === JSON.stringify(v2);
			},
		},
	},
};
const formu = document.getElementById("form-clave-modificar");

formu.addEventListener("submit", (e) => {
	e.preventDefault();

	const formData = new FormData(formu);

	let validar = validate({
			claveVieja: formData.get("clave_Actual"),
			claveNueva: formData.get("nueva-clave"),
			claveRepetida: formData.get("repetir-clave"),
		},validarClave,{ fullMessages: false });
		 
	if (validar) {
		removeSiblingErrors([claveNueva,claveVieja]);

		if(validar.claveVieja){
            addSiblingError(claveVieja, validar.claveVieja[0]);

		}else if(validar.claveNueva){
            addSiblingError(claveNueva, validar.claveNueva[0]);

		}
	} else {
		removeSiblingErrors([claveNueva,claveVieja]);
		try {
			fetch("https://pokeapi.cos/api/v2/pokemon/ditto", {
				method: "GET",
				//method: "POST",
				//body: formData
			}).then(response => response.json())
				.then(data => {
					if (data.ok) {
						//si todo sale bien va por aqui
						formu.reset();
					} else {
						//si la peticion es distinta a 200 - 299
						formu.reset();
						msjAlert('mensaje-error-clave','No se pudo realizar la peticion')

					}
				}).catch((error) => {
					//si no se puede realizar la peticion
					formu.reset();
					//addError(document.getElementById('form-login'),'Error: no se pudo procesar la peticion')
					//setInterval(()=>{removeError(document.getElementById('manejador'))},3000)
					msjAlert('mensaje-error-clave','No se pudo realizar la peticion')
				});

		} catch (error) {
			formu.reset();
			msjAlert('mensaje-error-clave','Error, No se puede comunicar con el servidor')
		}
	}
});

