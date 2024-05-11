export default function pacienteBeneficiadoEmergenciaInput (inputRadio) {
    
    const beneficiadoSelect = document.getElementById("cedula_beneficiado");
    const beneficiadoSelectLabel = document.getElementById("cedula_beneficiado-label");

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
