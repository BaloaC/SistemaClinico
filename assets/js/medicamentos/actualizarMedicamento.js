import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import { patterns } from "../global/patternsValidation.js";
import updateModule from "../global/updateModule.js";
import validateInputsOnUpdate from "../global/validateInputsOnUpdate.js";

async function updateMedicamento(id) {

    const $form = document.getElementById("act-medicamento");

    try {
        const json = await getById("medicamento", id);
        //Establecer el option con los datos del usuario
        $form.nombre_medicamento.value = json[0].nombre_medicamento;
        $form.nombre_medicamento.dataset.secondValue = json[0].nombre_medicamento;
        $form.tipo_medicamento.dataset.secondValue = json[0].tipo_medicamento;

        // Seleccionar el valor por defecto
        for (const option of $form.tipo_medicamento.options) {
            if (option.value === json[0].tipo_medicamento) {
                option.defaultSelected = true;
            }
        }

        // Crear el option por defecto
        createOptionOrSelectInstead({
            obj: {especialidad_id: json[0].especialidad_id, nombre: json[0].nombre_especialidad},
            selectSelector: "#s-especialidad-update",
            selectNames: ["nombre"],
            selectValue: "especialidad_id"
        });

        // Añadirle el dataset en caso de que no cambie su valor
        $form["s-especialidad-update"].dataset.secondValue = json[0].especialidad_id;

        validateInputsOnUpdate();

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "medicamento_id";
        // ! Para evitar error sql del endpoint
        // $inputId.dataset.secondValue = id;
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateMedicamento = updateMedicamento;

async function confirmUpdate() {
    const $form = document.getElementById("act-medicamento"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 3) throw { message: "El nombre debe contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        const parseData = deleteSecondValue("#act-medicamento input, #act-medicamento select", data);

        await updateModule(parseData, "medicamento_id", "medicamento", "act-medicamento", "Medicamento actualizado exitosamente!");

        cleanValdiation("info-medicamento");
        cleanValdiation("act-medicamento")
        $('#medicamentos').DataTable().ajax.reload();

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
    selectNames: ["nombre"],
    module: "especialidades/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione una especialidad",
    selectWidth: "100%"
});