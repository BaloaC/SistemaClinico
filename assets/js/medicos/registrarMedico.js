import addModule from "../global/addModule.js";
import { mostrarMedicos } from "./mostrarMedicos.js";

async function addMedico() {
    const $form = document.getElementById("info-medico"),
        $alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {},
            especialidad = [];

        formData.forEach((value, key) => (data[key] = value));

        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        data.telefono = data.cod_tel + data.telefono;
        let especialidades = formData.getAll("especialidad[]");
        especialidades.forEach(e => {
            const especialidad_id = {
                especialidad_id: e
            }
            especialidad.push(especialidad_id);
        })
        data.especialidad = especialidad;

        let checkboxes = document.getElementsByName("horario"),
            horario = [];
        checkboxes.forEach(e => {
            if(e.checked){
                const dias_semana = {
                    dias_semana: e.value
                }
                horario.push(dias_semana);
            }
        })
        data.horario = horario;

        await addModule("medicos", "info-medico", data, "Médico registrado exitosamente!");
        mostrarMedicos();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addMedico = addMedico;