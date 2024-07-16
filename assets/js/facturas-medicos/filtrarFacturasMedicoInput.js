function filtrarFacturasMedicoInput(input) {

    switch (input.name) {

        case "usuario":
            
                const selectMedico = document.getElementById("s-medico-filter");
                input.checked ? selectMedico.disabled = false : selectMedico.disabled = true;
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

window.filtrarFacturasMedicoInput = filtrarFacturasMedicoInput;