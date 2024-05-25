import dinamicSelect2 from "../global/dinamicSelect2.js";


export default async function consultaSinCita(inputRadio) {
    
    const pacienteSelect = document.getElementById("s-paciente");
    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const citaSelect = document.getElementById("s-cita");
    const inputDateConsulta = document.querySelector("input[name='fecha_consulta']");
    const inputDateConsultaLabel = document.querySelector("label[for='fecha_consulta']");
    const inputDateConsultaHidden = document.getElementById("fecha_consulta_cita");
    
    const consultaCita = document.querySelector(".input[name='consultaPorEmergencia']:checked");
    
    if(inputRadio.value === "0"){

        pacienteSelect.disabled = true;
        medicoSelect.disabled = true;
        especialidadSelect.disabled = true;
        citaSelect.disabled = false;
        $(".info-cita").fadeIn("slow");
        $(".info-paciente").fadeOut("slow");
        $(".info-medico").fadeOut("slow");
        $(inputDateConsulta).fadeOut("slow");
        inputDateConsulta.disabled = true;
        $(inputDateConsultaLabel).fadeOut("slow");
        inputDateConsultaHidden.disabled = false;

    } else{

        if(inputRadio.value === "1"){
            medicoSelect.disabled = true;
            especialidadSelect.disabled = true;
            $(".info-medico").fadeOut("slow");
        } else {
            medicoSelect.disabled = false;
            especialidadSelect.disabled = false;
            $(".info-medico").fadeIn("slow");
        }

        pacienteSelect.disabled = false;
        
        citaSelect.disabled = true;
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        $(".inputPacienteBeneficiadoEmergencia").fadeOut("slow");
        $("#pacienteBeneficiadoEmergenciaLabel").fadeOut("slow");
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        $(".info-cita").fadeOut("slow");
        $(".info-paciente").fadeIn("slow");
        $(inputDateConsulta).fadeIn("slow");
        inputDateConsulta.disabled = false;
        $(inputDateConsultaLabel).fadeIn("slow");
        inputDateConsultaHidden.disabled = true;
    }

}

document.getElementById("s-tipo_consulta").addEventListener("change", function () {
    consultaSinCita(this);
});

window.consultaSinCita = consultaSinCita;
