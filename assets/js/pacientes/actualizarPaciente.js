import deleteSecondValue from "../global/deleteSecondValue.js";
import getAge from "../global/getAge.js";
import getById from "../global/getById.js";
import updateModule from "../global/updateModule.js";

async function updatePaciente(id) {

    const $form = document.getElementById("act-paciente");

    try {
        const json = await getById("pacientes", id);

        // Obtener código telefónico
        let $telCod = json.telefono.slice(0, 4),
            $tel = json.telefono.split($telCod);

        for (const option of $form.cod_tel.options) {
            if (option.value === $telCod) {
                option.defaultSelected = true;
            }
        }

        for (const option of $form.tipo_paciente.options) {
            if (option.value === json.tipo_paciente) {
                option.defaultSelected = true;
            }
        }

        //Establecer el option con los datos del usuario
        $form.nombres.value = json.nombres || json.nombre_paciente;
        $form.nombres.dataset.secondValue = json.nombres || json.nombre_paciente;
        $form.apellidos.value = json.apellidos;
        $form.apellidos.dataset.secondValue = json.apellidos;
        $form.cedula.value = json.cedula;
        $form.cedula.dataset.secondValue = json.cedula;
        $form.fecha_nacimiento.value = json.fecha_nacimiento;
        $form.fecha_nacimiento.dataset.secondValue = json.fecha_nacimiento;
        $form.direccion.value = json.direccion;
        $form.direccion.dataset.secondValue = json.direccion;
        $form.telefono.value = $tel[1];
        $form.telefono.dataset.secondValue = $tel[1];
        $form.cod_tel.dataset.secondValue = $telCod;
        $form.tipo_paciente.dataset.secondValue = json.tipo_paciente

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "paciente_id";
        $form.appendChild($inputId);

        const $inputEdad = document.createElement("input");
        $inputEdad.type = "hidden";
        $inputEdad.value = json.edad;
        $inputEdad.dataset.secondValue = json.edad;
        $inputEdad.name = "edad";
        $form.appendChild($inputEdad);

    } catch (error) {

        console.log(error);
    }
}

window.updatePaciente = updatePaciente;

async function confirmUpdate() {
    const $form = document.getElementById("act-paciente"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        let $tel = data.cod_tel + data.telefono;

        const parseData = deleteSecondValue("#act-paciente input, #act-paciente select", data);

        // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
        if ('telefono' in parseData || 'cod_tel' in parseData) { parseData.telefono = $tel }
        if ('fecha_nacimiento' in parseData) {
            let edad = data.fecha_nacimiento.split("-");
            parseData.edad = getAge(edad[0], edad[1], edad[2]);
        }

        await updateModule(parseData, "paciente_id", "pacientes", "act-paciente", "Paciente actualizado correctamente!");

        $('#pacientes').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdate = confirmUpdate;