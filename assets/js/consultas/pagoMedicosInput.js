export default function pagoMedicosInput (inputRadio) {

    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const medicoPagoSelect = document.getElementById("s-medico-pago");
    
    const pagoMedicoContainer = document.querySelector(".info-pago-medico");
    const pagoMedicoBtn = document.getElementById("addMedicoPago");

    if(inputRadio === "0"){

        $(pagoMedicoContainer).fadeOut("slow");
        $(pagoMedicoBtn).fadeOut("slow");
        $(medicoPagoSelect).val([]).trigger("change");
        medicoPagoSelect.classList.remove("is-valid");
    } else{
        $(pagoMedicoContainer).fadeIn("slow");
        $(pagoMedicoBtn).fadeIn("slow");
        $(medicoPagoSelect).val(medicoSelect.value ?? []).trigger("change");
        medicoPagoSelect.classList.remove(!medicoSelect.value ? "is-valid" : "a");
    }

}

window.pagoMedicosInput = pagoMedicosInput;
