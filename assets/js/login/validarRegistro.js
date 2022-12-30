import {addSiblingError,removeSiblingErrors,msjAlert} from "../errors.js";
let nombreCompleto =document.getElementById('nombreCompleto');
let nombreUsuario =document.getElementById('nombreUsuario');
let clave =document.getElementById('clave');
let correo =document.getElementById('correoElectronico');
let condiciones =document.getElementById('aceptarCondiciones');

const validarRegistro = {
    nombreCompleto: {
        presence: true,
        length: {
            minimum: 10,
            message: 'Se tiene que escribir el nombre completo'
        },
    },
    nombreUsuario: {
        presence: true,
        length: {
            minimum: 3,
            message: "El nombre de usuario tiene que ser mayor a 3 caracteres"
        },
    },
    clave: {
        presence: true,
        length: {
            minimum: 6,
            message: "Se tiene que escribir una clave mas larga"
        },
        equality: {
            attribute: "claveRepetida",
            message: "No coinciden las claves",
            comparator: function (v1, v2) {
                return JSON.stringify(v1) === JSON.stringify(v2);
            }
        }
    },
    correoElectronico: {
        presence: true,
        email: {
            message: 'Correo no valido'
        }
    },
    aceptarCondiciones:{
        presence: true
    }
}
const form = document.getElementById('form-registro');
form.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    let validaciones = validate({
        nombreCompleto: formData.get('nombre_completo'),
        nombreUsuario: formData.get('nombre_usuario'),
        clave: formData.get('clave'),
        claveRepetida: formData.get('confirmar_clave'),
        correoElectronico: formData.get('correo_electronico'),
        aceptarCondiciones: formData.get('condServi')

    }, validarRegistro, { fullMessages: false });
   
    if (validaciones) {
        //se eliminan todos los errores viejos antes de añadir nuevos
        removeSiblingErrors([nombreCompleto, nombreUsuario, correoElectronico, clave, condiciones]);

        //se realizan todas las comprobaciones de golpe en vez de una en una
        if(validaciones.nombreCompleto){
            addSiblingError(nombreCompleto, validaciones.nombreCompleto[0]);
        }
        if(validaciones.nombreUsuario){
            addSiblingError(nombreUsuario, validaciones.nombreUsuario[0]);
            
        }
        if(validaciones.clave){
            addSiblingError(clave, validaciones.clave[0]);
            
        }
        if(validaciones.correoElectronico){
            addSiblingError(correo, validaciones.correoElectronico[0]);

        }
        if(validaciones.aceptarCondiciones){
            addSiblingError(condiciones, validaciones.aceptarCondiciones[0]);
        }
        /*
        */

    } else {
        // se eliminan todos los errores si no hay validaciones
        removeSiblingErrors([nombreCompleto, nombreUsuario, correoElectronico, clave, condiciones]);
        
        try {
            fetch('"https://pokeapi.co/api/v2/pokemon/ditto"', {
                method: 'GET'
                //method: 'POST',
                //data: formData

            }).then(respuesta => respuesta.json())
            
            .then((respuesta) => {
                if (respuesta.ok) {
                    //redirigir al login
                    form.reset();
                } else {
                    //mandar un mensaje de error ya que la solicitud tiene un codigo diferente a 200 - 299
                    form.reset();
			        msjAlert('mensaje-error','Error, No se puedo registrar el nuevo usuario')
                }
            }).catch((error) => {
                form.reset();
			    msjAlert('mensaje-error','No se puedo realizar la peticion')
            })
        } catch (error) {
            form.reset();
			msjAlert('mensaje-error','Error, No se puede comunicar con el servidor')
        }

    }
})
