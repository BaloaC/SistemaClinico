import { emptyAllSelect2, emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import pagoMedicosInput from "./pagoMedicosInput.js";

function turnInput(container,disabled){
    const containerParent = document.querySelector(container);
    const elements = containerParent.querySelectorAll("input, select");
    elements.forEach((element) => {
        element.disabled = disabled;
      });
}


export default async function consultaEmergencia(inputRadio) {
    
    const pacienteSelect = document.getElementById("s-paciente");  
    const pacienteBeneficiado = document.getElementById("cedula_beneficiado");
    const seguroSelect = document.getElementById("s-seguro-emergencia");
    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const citaSelect = document.getElementById("s-cita");

    const sinCitaSi = document.getElementById("consultaCitaSi");
    const sinCitaNo = document.getElementById("consultaCitaNo");

    // No es por emergencia
    if(inputRadio.value === "0"){

        const popover = bootstrap.Popover.getOrCreateInstance(document.getElementById('cedula_beneficiado'));
        if(popover._isEnabled) popover.hide();

        $(".sinCitaContainer").fadeIn("slow");
        $(".info-consulta-emergencia").fadeOut("slow");
        turnInput(".info-consulta-emergencia",true);
        $(".info-pago-medico").fadeOut("slow");
        turnInput(".info-pago-medico",true);
        $("#addMedicoPago").fadeOut("slow");
        // seguroSelect.disabled = true;

        if(sinCitaNo.checked){
            // citaSelect.disabled = false
            $(".info-cita").fadeIn("slow");
            $(".info-paciente").fadeOut("slow");
            $(".info-medico").fadeOut("slow");
            // pacienteSelect.disabled = true;
            // medicoSelect.disabled = true;
            // especialidadSelect.disabled = true;
        } else{
            $(".info-paciente").fadeIn("slow");
            $(".info-medico").fadeIn("slow");
            // pacienteSelect.disabled = false;
            // medicoSelect.disabled = false;
            // especialidadSelect.disabled = false;
        };

        

        $("#cedula_beneficiado-label").fadeOut("slow");
        $("#cedula_beneficiado").fadeOut("slow");
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        // pacienteBeneficiado.disabled = true;

    } else{ // Es por emergencia

        $(".sinCitaContainer").fadeOut("slow");
        $(".info-consulta-emergencia").fadeIn("slow");
        turnInput(".info-consulta-emergencia",false);
        turnInput(".info-pago-medico",false);
        $(".info-cita").fadeOut("slow");
        $("#registrarPagoMedicoLabel").fadeIn("slow");
        $(".inputRadioPagoMedico").fadeIn("slow");

        const pagoMedicosChecked = document.getElementById("RegistrarPagoMedicoSi");
        pagoMedicosChecked.checked ? pagoMedicosInput("1") : pagoMedicosInput("0");
       
        // citaSelect.disabled = true;
        // seguroSelect.disabled = true;
        

        if(sinCitaNo.checked){
            $(".info-paciente").fadeIn("slow");
            $(".info-medico").fadeIn("slow");
            // pacienteSelect.disabled = false;
            // medicoSelect.disabled = false;
            // !especialidadSelect.value ? especialidadSelect.disabled = true : especialidadSelect.disabled = false;
        } 
                    

        $("#cedula_beneficiado-label").fadeIn("slow");
        $("#cedula_beneficiado").fadeIn("slow");
        $("#cedulaBeneficiadoSmall").fadeIn("slow");
        // pacienteBeneficiado.disabled = false;
    }

}

window.consultaEmergencia = consultaEmergencia;
