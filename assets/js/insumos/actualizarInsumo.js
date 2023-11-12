import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import getById from "../global/getById.js";
import { patterns } from "../global/patternsValidation.js";
import updateModule from "../global/updateModule.js";
import validateInputsOnUpdate from "../global/validateInputsOnUpdate.js";

const d = document,
    path = location.pathname.split('/');


async function updateEspecialidad(id) {

    const $form = d.getElementById("act-insumo");

    try {
        const json = await getById("insumos", id);
        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;

        validateInputsOnUpdate();

        const $inputId = d.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "especialidad_id";
        // ! Para evitar error sql del endpoint
        // $inputId.dataset.secondValue = id;
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateEspecialidad = updateEspecialidad;

async function confirmUpdate() {
    const $form = d.getElementById("act-especialidad"),
        $alert = d.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!data.nombre.length > 3) throw { message: "El nombre de contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.price.test(data.cantidad)) && !(patterns.price.test(data.cantidad_min))) throw { message: "Un campo númerico ingresado no es válido" };
        if (!(patterns.price.test(data.precio))) throw { message: "El precio ingresado no es válido" };

        const parseData = deleteSecondValue("#act-especialidad input, #act-especialidad select", data);
        
        await updateModule(parseData, "especialidad_id","especialidades","act-especialidad","Especialidad actualizada exitosamente!");

        cleanValdiation("act-especialidad");
        cleanValdiation("info-especialidad");
        $('#especialidades').DataTable().ajax.reload();

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