function filtrarAuditoriaInput(input) {
    console.log("🍓 ~ file: filtrarAuditoria.js:2 ~ filtrarAuditoriaInput ~ input:", input)


    switch (input.name) {
        case "accion":

                const selectAccion = document.getElementById("s-accion");
                input.checked ? selectAccion.disabled = false : selectAccion.disabled = true;
            break;
        case "modulo":
            
                const selectModulo = document.getElementById("s-modulo");
                input.checked ? selectModulo.disabled = false : selectModulo.disabled = true;
            break;
        case "usuario":
            
                const selectUsuario = document.getElementById("s-usuario");
                input.checked ? selectUsuario.disabled = false : selectUsuario.disabled = true;
            break;
        case "fecha":
            
                const fechaInicio = document.getElementById("fecha_inicio");
                const fechaFin = document.getElementById("fecha_fin");
                
                if(input.checked){
                    fechaInicio.disabled = false;
                    fechaFin.disabled = false;
                } else {
                    fechaInicio.disabled = true
                    fechaFin.disabled = true;
                }
            break;

    }

}

window.filtrarAuditoriaInput = filtrarAuditoriaInput;