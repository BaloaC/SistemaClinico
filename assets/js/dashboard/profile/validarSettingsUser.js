import {addSiblingError,removeSiblingErrors,msjAlert}  from "../../errors.js";

const nombreCompleto = document.getElementById('nombreCompleto');
const nombreUsuario = document.getElementById('nombreUsuario');
const vGenero = document.getElementById('vGenero');
const telefono = document.getElementById('telefono');
const correo = document.getElementById('correo');

const validarSettingProfile={
    nombreCompleto:{
        presence:true,
        length:{
            minimum:10,
            message: 'Se tiene que escribir el nombre completo'
        }
    },
    correo_electronico:{
        presence: true,
        email:{
            message:'Correo electronico no es valido'
        }
    },
    telefono:{
        presence:true,
        length:{
            minimum:11,
            message:'Numero de telefono no valido'
        }
    },
    nombreUsuario:{
        presence: true,
        length:{
            minimum: 3,
            message: 'el nombre de usuario tiene que tener mas de 3 caracteres'
        }
    },
    //buscar formar de validar el select
    genero:{
        presence:true,
        length:{
            minimum: 3,
            message: 'Se tiene que ingresar una opcion en genero'
        }
    }
}

let form = document.getElementById('form-detalles');

form.addEventListener('submit',(e)=>{
    e.preventDefault();

    const formData = new FormData(form);
  
    let validar = validate({
        nombreCompleto: formData.get('nombre_completo') , 
        nombreUsuario: formData.get('nombre_usuario') ,
        correo_electronico: formData.get('correo_electronico'),
        telefono: formData.get('telefono'),
        genero:  formData.get('genero')
    },validarSettingProfile,{fullMessages: false});
    console.log(validar)
    if(validar){
        
        removeSiblingErrors([nombreCompleto, nombreUsuario, vGenero, telefono, correo]);

        if(validar.nombreCompleto){

            addSiblingError(nombreCompleto, validar.nombreCompleto[0]);
        }
        else if(validar.telefono){
            addSiblingError(telefono, validar.telefono[0]);
        }
        else if(validar.nombreUsuario){
            addSiblingError(nombreUsuario, validar.nombreUsuario[0]);
        }
        else if(validar.correo_electronico){
            addSiblingError(correo, validar.correo_electronico[0]);
        }
        else if(validar.genero){
            addSiblingError(vGenero, validar.genero[0]);
        }
    }else{
        removeSiblingErrors([nombreCompleto, nombreUsuario, vGenero, telefono, correo]);
        try {
            fetch('https://pokeapi.co/api/v2/pokemon/ditto',{
                method: 'GET',
                //method: 'PUT',
                //body: formData
            }).then(response => response.json())

                .then(data=>{

                    if(data.ok){
                        //aqui va lo que sucedera si todo sale bien
                        form.reset();
                    }else{
                        //aqui se envia el mensaje de error
                        form.reset();
						msjAlert('mensaje-error-datos','Error no se pudo realizar la actualizacion de los datos')
                        
                    }
                })
                .catch((error)=>{
                    //se maneja el error
                    form.reset();
                    msjAlert('mensaje-error-datos','No se pudo realizar la peticion')
    
                })
        } catch (error) {
            form.reset();
            msjAlert('mensaje-error-datos','Error, servidor caido')
    
        }

    }

})