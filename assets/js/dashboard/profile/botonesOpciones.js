
let btnEditar = document.getElementById('editar-perfil');
let btnClave = document.getElementById('cambiar-clave');

const verInformacion = document.getElementById('user-info');
const editarInformacion = document.getElementById('user-edit');
const editarClave = document.getElementById('password-edit');

//Función para alternar botones
function ocultarBotones(bool) {
    if (bool == true) {

        btnClave.classList.toggle('opacity');
        setTimeout(() => {
            btnClave.classList.toggle('d-none');    
        }, 200);

    } else if (bool == false) {

        btnEditar.classList.toggle('opacity');
        setTimeout(() => {
            btnEditar.classList.toggle('d-none');
        }, 300);

    }
}

//Script para el panel de edición de información
let toggleEditar = bool => {
    if (bool == true) {
        
        setTimeout(() => {
            editarInformacion.classList.toggle('d-none');
            verInformacion.classList.toggle('d-none');
            verInformacion.classList.toggle('opacity');
        }, 300);

    } else if (bool == false) {
        
        setTimeout(() => {
            verInformacion.classList.toggle('d-none');
            editarInformacion.classList.toggle('d-none');
            editarInformacion.classList.toggle('opacity');
        }, 300);
    }
}

// función al hacer click a los botones editar/cancelar informacion
function cancelarEdicion() {
    if (verInformacion.classList.contains("opacity")) {

        editarInformacion.classList.toggle('opacity');
        ocultarBotones(true);
        toggleEditar(true);

    } else {
        
        verInformacion.classList.toggle('opacity');    
        ocultarBotones(true);
        toggleEditar(false);
    }    
}

//script para el panel de cambio de contraseña
let toggleEliminar = bool => {
    if (bool == true) {
        
        setTimeout(() => {
            editarClave.classList.toggle('d-none');
            verInformacion.classList.toggle('d-none');
            verInformacion.classList.toggle('opacity');
        }, 300);

    } else if (bool == false) {
        
        setTimeout(() => {
            verInformacion.classList.toggle('d-none');
            editarClave.classList.toggle('d-none');
            editarClave.classList.toggle('opacity');
        }, 300);
    }
}

// función al hacer click a los botones cambiar/cancelar cambio de contraseña
function cancelarCambio() {
    if (verInformacion.classList.contains("opacity")) {

        editarClave.classList.toggle('opacity');
        ocultarBotones(false);
        toggleEliminar(true);

    } else {
        
        verInformacion.classList.toggle('opacity');    
        ocultarBotones(false);
        toggleEliminar(false);
    }    
}