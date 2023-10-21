import addModule from "../global/addModule.js";
import getAll from "../global/getAll.js";
import { medicosPagination } from "./medicosPagination.js";
import { mostrarMedicos } from "./mostrarMedicos.js";

async function addMedico() {
    const $form = document.getElementById("info-medico"),
        $alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {},
            especialidad = [];

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.apellidos))) throw { message: "El apellido ingresado no es válido" };
        if (data.nombre.length < 3) throw { message: "El nombre debe tener al menos 3 caracteres" };
        if (data.apellidos.length < 3) throw { message: "El apellido debe tener al menos 3 caracteres" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.apellidos))) throw { message: "El apellido ingresado no es válido" };
        if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        // if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

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

            if (e.checked) {

                // [0] = Hora entrada | [1] = Hora salida
                const inputsTime = e.parentElement.parentElement.parentElement.querySelectorAll("input[type='time']");

                if(inputsTime[0].value >= inputsTime[1].value){
                    throw { message: `La hora de salida es menor igual a la fecha de entrada en el día ${e.value}` }
                }

                const dias_semana = {
                    dias_semana: e.value,
                    hora_entrada: inputsTime[0].value,
                    hora_salida: inputsTime[1].value
                }
                horario.push(dias_semana);
            }
        })
        data.horario = horario;

        if(horario.length <= 0) throw { message: "No se ha seleccionado ningún día disponible del médico" };

        await addModule("medicos", "info-medico", data, "Médico registrado exitosamente!");
        const listadoMedico = await getAll("medicos/consulta");
        medicosPagination(listadoMedico);
        Array.from(document.getElementById("info-medico").elements).forEach(element => {
            element.classList.remove('valid');
        })
        document.querySelectorAll("input[type='time']").forEach(element => element.disabled = true);
        $("#s-especialidad").val([]).trigger('change'); //Vaciar select2

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addMedico = addMedico;