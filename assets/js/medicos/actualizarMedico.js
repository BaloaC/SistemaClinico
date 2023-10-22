import deleteSecondValue from "../global/deleteSecondValue.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import scrollTo from "../global/scrollTo.js";
import updateModule from "../global/updateModule.js";
import validateInputsOnUpdate from "../global/validateInputsOnUpdate.js";
import { medicosPagination } from "./medicosPagination.js";
import { mostrarMedicos } from "./mostrarMedicos.js";

async function updateMedico(id) {

    const $form = document.getElementById("act-medico");
    const horariosTemplate = document.getElementById("horarioInitialInputs").content.cloneNode(true);
    const horariosContainer = document.querySelector(".act-horarios");

    try {

        const json = await getById("medicos", id);

        // especialidad = await getById("especialidades", json[0].especialidad_id);
        console.log(json);

        // Obtener código telefónico
        let $telCod = json[0].telefono.slice(0, 4),
            $tel = json[0].telefono.split($telCod);

        for (const option of $form.cod_tel.options) {
            if (option.value === $telCod) {
                option.defaultSelected = true;
            }
        }

        json[0].especialidad.forEach(el => {
            createOptionOrSelectInstead({
                obj: el,
                selectSelector: "#s-especialidad-update",
                selectNames: ["nombre_especialidad"],
                selectValue: "especialidad_id"
            });
        })

        // Restablecemos los horarios por default
        horariosContainer.replaceChildren(horariosTemplate);


        const horarioInput = document.querySelectorAll(".horarioInput");
        const horaEntradaInput = document.querySelectorAll(".horarioEntryInput");
        const horaSalidaInput = document.querySelectorAll(".horarioExitInput");

        horarioInput.forEach((checkbox, index) => {

            // Validamos que los checkbox concuerden con los que ya existan
            json[0]?.horario?.some(horario => {
                if (horario.dias_semana == checkbox.value) {
                    checkbox.checked = true;
                    checkbox.disabled = true;
                    horaEntradaInput[index].disabled = true;
                    horaEntradaInput[index].value = horario.hora_entrada;
                    horaSalidaInput[index].disabled = true;
                    horaSalidaInput[index].value = horario.hora_salida;
                }
            });
        });


        // json[0].horario.forEach((horario, index) => {

        //     let algunValorCoincide = horarioInput.some(function (objeto) {
        //         return horario.dias_semana === objeto.value;
        //     });

        //     if (algunValorCoincide) {
        //         checkbox.checked = true;
        //     }
        // })

        //Establecer el option con los datos del usuario
        // $form.especialidad_id.dataset.secondValue = especialidad.especialidad_id;
        $form.cedula.value = json[0].cedula;
        $form.cedula.dataset.secondValue = json[0].cedula;
        $form.nombre.value = json[0].nombre;
        $form.nombre.dataset.secondValue = json[0].nombre;
        $form.apellidos.value = json[0].apellidos;
        $form.apellidos.dataset.secondValue = json[0].apellidos;
        $form.telefono.value = $tel[1];
        $form.telefono.dataset.secondValue = $tel[1];
        $form.cod_tel.dataset.secondValue = $telCod;
        $form.direccion.value = json[0].direccion;
        $form.direccion.dataset.secondValue = json[0].direccion;

        validateInputsOnUpdate();

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "medico_id";
        // ! Para evitar error del endpoint
        $inputId.dataset.secondValue = id;
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateMedico = updateMedico;

async function confirmUpdate() {
    const $form = document.getElementById("act-medico"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.apellidos))) throw { message: "El apellido ingresado no es válido" };
        if (data.nombre.length < 3) throw { message: "El nombre debe tener al menos 3 caracteres" };
        if (data.apellidos.length < 3) throw { message: "El apellido debe tener al menos 3 caracteres" };
        if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

        // ! Para evitar error del endpoint
        let medico_id = data.medico_id;
        let $tel = data.cod_tel + data.telefono;
        delete data["especialidad[]"];

        const parseData = deleteSecondValue("#act-medico input, #act-medico select", data);
        parseData.medico_id = medico_id;
        // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
        if ('telefono' in parseData || 'cod_tel' in parseData) { parseData.telefono = $tel }


        let checkboxes = document.querySelectorAll(".horarioInput");
        let horario = [];

        checkboxes.forEach(e => {

            if (e.checked && e.disabled == false) {

                // [0] = Hora entrada | [1] = Hora salida
                const inputsTime = e.parentElement.parentElement.parentElement.querySelectorAll("input[type='time']");

                console.log(inputsTime);
                if (inputsTime[0].value >= inputsTime[1].value && (inputsTime[0].disabled == false || inputsTime[1].disabled == false)) {
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

        if (horario && horario.length > 0) { parseData.horario = horario; }

        // ! Para evitar error del endpoint
        if (!Object.entries(parseData).length == 0) {
        }

        await updateModule(parseData, "medico_id", "medicos", "act-medico", "Medico actualizado correctamente!");
        const listadoMedico = await getAll("medicos/consulta");
        medicosPagination(listadoMedico);


    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        scrollTo("modalActBody");
        
        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdate = confirmUpdate;

select2OnClick({
    selectSelector: "#s-especialidad-update",
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    module: "especialidades/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione una especialidad",
});

