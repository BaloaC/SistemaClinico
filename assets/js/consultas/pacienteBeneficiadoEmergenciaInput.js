export default function pacienteBeneficiadoEmergenciaInput (inputRadio) {

    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const medicoPagoSelect = document.getElementById("s-medico-pago");
    
    const beneficiadoSelect = document.getElementById("cedula_beneficiado");
    const beneficiadoSelectLabel = document.getElementById("cedula_beneficiado-label");

    const pagoMedicoContainer = document.querySelector(".info-pago-medico");
    const pagoMedicoBtn = document.getElementById("addMedicoPago");

    if(inputRadio == "0"){


        $(".inputCedulaBeneficiado").fadeOut("slow")
        $(beneficiadoSelectLabel).fadeOut("slow");
        beneficiadoSelect.disabled = true;

    } else{

        $(".inputCedulaBeneficiado").fadeIn("slow")
        $(beneficiadoSelectLabel).fadeIn("slow");
        beneficiadoSelect.disabled = false;
    }

}

window.pacienteBeneficiadoEmergenciaInput = pacienteBeneficiadoEmergenciaInput;
