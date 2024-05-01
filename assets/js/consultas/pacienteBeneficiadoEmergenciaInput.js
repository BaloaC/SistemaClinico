export default function pacienteBeneficiadoEmergenciaInput (inputRadio) {

    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const medicoPagoSelect = document.getElementById("s-medico-pago");
    
    const beneficiadoSelect = document.getElementById("cedula_beneficiado");
    const beneficiadoSelectLabel = document.getElementById("cedula_beneficiado-label");

    const pagoMedicoContainer = document.querySelector(".info-pago-medico");
    const pagoMedicoBtn = document.getElementById("addMedicoPago");

    console.log(inputRadio);

    if(inputRadio == "0"){


        $(".inputCedulaBeneficiado").fadeOut("slow")
        $(beneficiadoSelectLabel).fadeOut("slow");
        beneficiadoSelect.disabled = true;
        

        // $(pagoMedicoContainer).fadeOut("slow");
        // $(pagoMedicoBtn).fadeOut("slow");
        // $(medicoPagoSelect).val([]).trigger("change");

        // medicoPagoSelect.classList.remove("is-valid");


    } else{
        
    


        // alert("a");

        $(".inputCedulaBeneficiado").fadeIn("slow")
        $(beneficiadoSelectLabel).fadeIn("slow");
        beneficiadoSelect.disabled = false;

        // $(pagoMedicoContainer).fadeIn("slow");
        // $(pagoMedicoBtn).fadeIn("slow");
        // $(medicoPagoSelect).val(medicoSelect.value ?? []).trigger("change");
        // medicoPagoSelect.classList.remove(!medicoSelect.value ? "is-valid" : "a");
    }

}

window.pacienteBeneficiadoEmergenciaInput = pacienteBeneficiadoEmergenciaInput;
