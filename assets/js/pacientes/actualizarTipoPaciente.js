export default async function actualizarTipoPaciente(value){
    
    // Paciente asegurado
    if(value === "3"){

        $(".submenu-seguro").fadeIn("slow");
        $(".submenu-beneficiado").fadeOut("slow");
    } else if(value === "4"){

        $(".submenu-beneficiado").fadeIn("slow");
        $(".submenu-seguro").fadeOut("slow");
    } else{
        
        $(".submenu-beneficiado").fadeOut("slow");
        $(".submenu-seguro").fadeOut("slow");
    }
}

window.actualizarTipoPaciente = actualizarTipoPaciente;