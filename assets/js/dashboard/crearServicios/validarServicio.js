import {addSiblingError,removeSiblingErrors,msjAlert} from "../../errors.js";

const validarPartUno={
    titulo:{
        presence: true,
        length:{
            minimum: 3,
            message:'El titulo tiene que ser mas largo'
        }
    },
    descripcion:{
        presence: true,
        length: {
            minimum: 40,
            message: 'La descripcion tiene que ser mas larga'
        }
    },
    categoria:{
        presence: true,
        exclusion: {
            within: {'sin_categoria': "sin_categoria"},
            message: "Se tiene que agregar una categoria"
        }
    }
}

const validarPartdos = {
    codigoTlfn:{
        presence:true,
        exclusion: {
            within: {'sin_tipo': "sin_tipo"},
            message: "Se tiene que agregar el tipo de numero de conctato"
        }
    },
    numeroTlfn:{
        presence:true,
        length:{
            minimum:7,
            message:'Se tiene que agregar el numero de telefono'
        }
    }
}

const btmPaso1 = document.getElementById('boton-paso1');
const btmPaso2 = document.getElementById('boton-paso1');


const btmSuPaso1 = document.getElementById('nav-item-info-tab');
const btmSuPaso2 = document.getElementById('nav-item-details-tab');
const btmSuPaso3 = document.getElementById('nav-user-info-tab');


//btmPaso1?.onclick = validarParteUno
//btmPaso2?.onclick = validarParteDos

export function validarParteUno(event){

    //btmSuPaso3.setAttribute('class','nav-link');
    //btmSuPaso2.setAttribute('class','nav-link');
    //btmSuPaso1.setAttribute('class','nav-link active');

    let titulo_servicio = document.getElementById('tituloServicio');
    let descripcion_servicio = document.getElementById('descripcionServicio');
    let categoria_servicio = document.getElementById('categoria');

    const resultadoValidacion = validate({
        titulo: titulo_servicio.value,
        descripcion : descripcion_servicio.value,
        categoria: categoria_servicio.value
    },validarPartUno,{ fullMessages: false })
    
    if(resultadoValidacion){
        removeSiblingErrors([titulo_servicio,descripcion_servicio,categoria_servicio])

        if(resultadoValidacion.titulo){
            addSiblingError(titulo_servicio,resultadoValidacion.titulo);
            console.log('adding error');
            
        }
        if(resultadoValidacion.descripcion){
            addSiblingError(descripcion_servicio,resultadoValidacion.descripcion);

        }
        if(resultadoValidacion.categoria){
            addSiblingError(categoria_servicio,resultadoValidacion.categoria);
        }
    }else{
        removeSiblingErrors([titulo_servicio,descripcion_servicio,categoria_servicio])
        //btmPaso1.setAttribute('data-bs-toggle','tab');
        //btmPaso1.setAttribute('data-bs-target',"#nav-item-details");
        //btmPaso1.click();
        
        //btmSuPaso1.setAttribute('class','nav-link');
        //btmSuPaso3.setAttribute('class','nav-link');
        //btmSuPaso2.setAttribute('class','nav-link active');

    }
    return resultadoValidacion;
}

function validarParteDos(event){
    btmSuPaso3.setAttribute('class','nav-link');
    btmSuPaso2.setAttribute('class','nav-link active');
    btmSuPaso1.setAttribute('class','nav-link ');

    let titulo_servicio = document.getElementById('tituloServicio');
    let descripcion_servicio = document.getElementById('descripcionServico');
    let categoria_servicio = document.getElementById('categoria');
}
/*
import {addSiblingError,removeSiblingErrors,msjAlert} from "../../errors.js";
btmPaso1.addEventListener('onclick',(e)=>{

    data-bs-toggle="tab" data-bs-target="#nav-item-info" 

    btmPaso1.setAttribute('data-bs-toggle','tab');
    btmPaso1.setAttribute('data-bs-target','"#nav-item-details"');

    btmPaso1.click();

    console.log(formPartUno)
    const formPartUno = document.getElementById('formPartUno');
})
*/
