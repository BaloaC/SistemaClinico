import deleteSecondValue from "../global/deleteSecondValue.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import updateModule from "../global/updateModule.js";
import { mostrarMedicos } from "./mostrarMedicos.js";

async function updateMedico(id) {

    const $form = document.getElementById("act-medico");

    try {

        const json = await getById("medicos", id),

        especialidad = await getById("especialidades", json[0].especialidad_id);
        console.log(json);

        console.log(json, especialidad);

        // Obtener código telefónico
        let $telCod = json[0].telefono.slice(0, 4),
            $tel = json[0].telefono.split($telCod);

        for (const option of $form.cod_tel.options) {
            if (option.value === $telCod) {
                option.defaultSelected = true;
            }
        }

        createOptionOrSelectInstead({
            obj: especialidad,
            selectSelector: "#s-especialidad-update",
            selectNames: ["nombres"],
            selectValue: "especialidad_id"
        });

        //Establecer el option con los datos del usuario
        $form.especialidad_id.dataset.secondValue = especialidad.especialidad_id;
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
        if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

        // ! Para evitar error del endpoint
        let medico_id = data.medico_id;
        let $tel = data.cod_tel + data.telefono;

        const parseData = deleteSecondValue("#act-medico input, #act-medico select", data);

        // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
        if ('telefono' in parseData || 'cod_tel' in parseData) { parseData.telefono = $tel }

        // ! Para evitar error del endpoint
        if (!Object.entries(parseData).length == 0) {
        }

        await updateModule(parseData, "medico_id", "medicos", "act-medico", "Medico actualizado correctamente!");
        mostrarMedicos();

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

select2OnClick({
    selectSelector: "#s-especialidad-update",
    selectValue: "especialidad_id",
    selectNames: ["nombres"],
    module: "especialidades/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione una especialidad",
});

