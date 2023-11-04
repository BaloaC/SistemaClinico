import getAge from "../global/getAge.js";

function pacienteMenorDeEdadUpdate(input) {

    let fechaNacimiento = input.value.split("-");
    let edad = getAge(fechaNacimiento[0], fechaNacimiento[1], fechaNacimiento[2]);

    const cedulaInput = document.getElementById("cedula-act");
    const telefonoInput = document.getElementById("telefono-act");
    const codTelInput = document.getElementById("cod-tel-act");
    const tipoPaciente = document.getElementById("tipo_paciente");
    const cedulaMenorLabel = document.querySelector("label[for='pacienteMenorLabelAct']");
    const cedulaMenorContainer = document.querySelector(".pacienteMenorContainerAct");
    const cedulaMenorSi = document.getElementById("cedula_menor_si_act");
    const cedulaMenorNo = document.getElementById("cedula_menor_no_act");
    console.log(edad);
    if (edad < 18) {

        // Validamos que si el paciente es mayor de 9 de años se permita eligir si posee cédula, caso contrario ocultamos los inputs radio
        if (edad >= 9) {
            cedulaMenorLabel.classList.remove("opacity-0");
            setTimeout(() => {
                cedulaMenorLabel.classList.remove("d-none");
            }, 550);

            cedulaMenorContainer.classList.remove("opacity-0");
            setTimeout(() => {
                cedulaMenorContainer.classList.remove("d-none");
            }, 550);
        } else{ 
            cedulaMenorLabel.classList.add("opacity-0");
            setTimeout(() => {
                cedulaMenorLabel.classList.add("d-none");
            }, 550);

            cedulaMenorContainer.classList.add("opacity-0");
            setTimeout(() => {
                cedulaMenorContainer.classList.add("d-none");
            }, 550);
        }

        cedulaInput.disabled = true;
        telefonoInput.disabled = true;
        codTelInput.disabled = true;
        cedulaMenorNo.checked = true;
        cedulaMenorNo.disabled = false;

        // Seleccionar por defecto el submenu de beneficiario
        tipoPaciente.selectedIndex = 3;
        tipoPaciente.dispatchEvent(new Event("change"));

    
        // Ciclo para deshabilitar los tipos de pacientes
        for (let i = 0; i < tipoPaciente.options.length; i++) {

            let option = tipoPaciente.options[i];
            if (i !== 3){ 
                option.disabled = true 
            } 
        }

    } else {

        // Seleccionar por defecto para que sea paciente natural
        tipoPaciente.selectedIndex = 1;
        tipoPaciente.dispatchEvent(new Event("change"));

        cedulaMenorLabel.classList.add("opacity-0");
        setTimeout(() => {
            cedulaMenorLabel.classList.add("d-none");
        }, 550);

        cedulaMenorContainer.classList.add("opacity-0");
        setTimeout(() => {
            cedulaMenorContainer.classList.add("d-none");
        }, 550);

        cedulaInput.disabled = false;
        telefonoInput.disabled = false;
        codTelInput.disabled = false;
        cedulaMenorNo.checked = true;
        cedulaMenorNo.disabled = true;


        // Ciclo para habilitar los tipos de pacientes
        for (let i = 0; i < tipoPaciente.options.length; i++) {
            let option = tipoPaciente.options[i];

            // Si el tipo de paciente es distinto a beneficiado lo habilitamos las opciones, caso contrario desabilitamos la opción de paciente beneficiado
            if (i !== 4){
                option.disabled = false;  
            } else {
                option.disabled = true;
            }
        }
    }
}

window.pacienteMenorDeEdadUpdate = pacienteMenorDeEdadUpdate;