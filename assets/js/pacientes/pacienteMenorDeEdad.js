import getAge from "../global/getAge.js";

function pacienteMenorDeEdad(input) {

    let fechaNacimiento = input.value.split("-");
    let edad = getAge(fechaNacimiento[0], fechaNacimiento[1], fechaNacimiento[2]);

    const cedulaInput = document.getElementById("cedula");
    const telefonoInput = document.getElementById("telefono");
    const codTelInput = document.getElementById("cod-tel");
    const tipoPaciente = document.getElementById("s-tipo_paciente");
    if (edad < 18) {
        cedulaInput.disabled = true;
        telefonoInput.disabled = true;
        codTelInput.disabled = true;

        // Ciclo para deshabilitar los tipos de pacientes
        for (let i = 0; i < tipoPaciente.options.length; i++) {
            let option = tipoPaciente.options[i];
            if (i !== 4) option.disabled = true;
        }

    } else {
        cedulaInput.disabled = false;
        telefonoInput.disabled = false;
        codTelInput.disabled = false;

        for (let i = 0; i < tipoPaciente.options.length; i++) {
            let option = tipoPaciente.options[i];

            if (i !== 4) option.disabled = false;
        }
    }
}

window.pacienteMenorDeEdad = pacienteMenorDeEdad;