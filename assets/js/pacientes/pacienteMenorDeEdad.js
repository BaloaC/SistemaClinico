import getAge from "../global/getAge.js";

function pacienteMenorDeEdad(input) {

    let fechaNacimiento = input.value.split("-");
    let edad = getAge(fechaNacimiento[0], fechaNacimiento[1], fechaNacimiento[2]);

    const cedulaInput = document.getElementById("cedula");
    const telefonoInput = document.getElementById("telefono");
    const codTelInput = document.getElementById("cod-tel");
    const tipoPaciente = document.getElementById("s-tipo_paciente");
    const cedulaMenorLabel = document.querySelector("label[for='pacienteMenorLabel']");
    const cedulaMenorContainer = document.querySelector(".pacienteMenorContainer");
    const cedulaMenorSi = document.getElementById("cedula_menor_si");
    const cedulaMenorNo = document.getElementById("cedula_menor_no");

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
        tipoPaciente.selectedIndex = 4;
        tipoPaciente.dispatchEvent(new Event("change"));

    
        // Ciclo para deshabilitar los tipos de pacientes
        for (let i = 0; i < tipoPaciente.options.length; i++) {
            let option = tipoPaciente.options[i];
            if (i !== 4) option.disabled = true;
        }

    } else {

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

            if (i !== 4) option.disabled = false;
        }
    }
}

window.pacienteMenorDeEdad = pacienteMenorDeEdad;

function pacientePoseeCedula(input) {

    const cedulaInput = document.getElementById("cedula");

    if (input.value == 1) {
        cedulaInput.disabled = false;
    } else {
        cedulaInput.disabled = true;
    }
}

window.pacientePoseeCedula = pacientePoseeCedula;
