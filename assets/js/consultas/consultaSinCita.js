import { emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";


export default async function consultaSinCita(inputRadio) {
    
    const pacienteSelect = document.getElementById("s-paciente");
    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const citaSelect = document.getElementById("s-cita");
    
    const consultaCita = document.querySelector(".input[name='consultaPorEmergencia']:checked");
    
    console.log(especialidadSelect.value, "cita"); 
    
    if(inputRadio.value === "0"){

        pacienteSelect.disabled = true;
        medicoSelect.disabled = true;
        especialidadSelect.disabled = true;
        citaSelect.disabled = false;
        $(".info-cita").fadeIn("slow");
        $(".info-paciente").fadeOut("slow");
        $(".info-medico").fadeOut("slow");
    } else{
        pacienteSelect.disabled = false;
        medicoSelect.disabled = false;
        especialidadSelect.disabled = false;
        citaSelect.disabled = true;
        $(".info-cita").fadeOut("slow");
        $(".info-paciente").fadeIn("slow");
        $(".info-medico").fadeIn("slow");
        // $("#cedulaBeneficiadoSmall").fadeOut("slow");
    }

}

window.consultaSinCita = consultaSinCita;
