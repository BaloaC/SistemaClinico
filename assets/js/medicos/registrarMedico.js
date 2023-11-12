import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";
import scrollTo from "../global/scrollTo.js";
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
        if (!(patterns.name.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.name.test(data.apellidos))) throw { message: "El apellido ingresado no es válido" };
        if (data.nombre.length < 3) throw { message: "El nombre debe tener al menos 3 caracteres" };
        if (data.apellidos.length < 3) throw { message: "El apellido debe tener al menos 3 caracteres" };
        if (!(patterns.dni.test(data.cedula))) throw { message: "La cédula no es válida" };
        if (!(patterns.address.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

        data.telefono = data.cod_tel + data.telefono;

        const especialidades = document.querySelectorAll(".medico-especialidad-id");
        const costoEspecialidad = document.querySelectorAll(".costo-especialidad");

        especialidades.forEach((value, key) => {
            
            const especialidad_id = {
                especialidad_id: value.value,
                costo_especialidad: costoEspecialidad[key].value
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
        cleanValdiation("info-medico");
        deleteElementByClass("newInput");
        document.querySelectorAll("input[type='time']").forEach(element => element.disabled = true);
        $("#s-especialidad").val([]).trigger('change'); //Vaciar select2
        $("#s-especialidad").removeClass("is-valid"); //Limpiar validación

    } catch (error) {
        console.log(error);

        scrollTo("modalRegBody");

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addMedico = addMedico;