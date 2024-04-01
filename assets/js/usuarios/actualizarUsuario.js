import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import { patterns } from "../global/patternsValidation.js";
import showDefaultModalAct from "../global/showDefaultModalAct.js";
import updateModule from "../global/updateModule.js";
import validateInputsOnUpdate from "../global/validateInputsOnUpdate.js";

async function updateUsuario(id) {

    const $form = document.getElementById("act-usuario");

    try {
        const json = await getById("usuarios", id);

        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.rol.dataset.secondValue = json.rol;

        // Seleccionar el valor por defecto
        for (const option of $form.rol.options) {
            if (option.value == json.rol) {
                option.defaultSelected = true;
            }
        }


        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "usuario_id";
        // ! Para evitar error sql del endpoint
        // $inputId.dataset.secondValue = id;
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateUsuario = updateUsuario;

async function confirmUpdate() {
    const $form = document.getElementById("act-usuario"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));


        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!((/^[a-zA-Z0-9_-]{1,16}$/).test(data.nombre))) throw { message: "Nombre de usuario inválido" };
        if (!((/^(?=.*\d)[\d\w@-]{8,20}$/i).test(data.clave)) && data.clave !== "") throw { message: "Contraseña inválida" };
        // if (!((/^\d{6,}$/).test(data.pin))) throw { message: "Pin inválido" };
        if (!(data.rol > 0 && data.rol <= 5)) throw { message: "Nivel de usuario inválido" };

        const parseData = deleteSecondValue("#act-usuario input, #act-usuario select", data);


        if(parseData.clave === "") delete parseData.clave;
        // Validamos que se envie al menos una propiedad para hacer la petición
        if (Object.values(parseData)?.length > 1) {

            await updateModule(parseData, "usuario_id", "usuarios", "act-usuario", "Usuario actualizado exitosamente!");
            $('#usuariosTable').DataTable().ajax.reload();
        } else {

            showDefaultModalAct({form: $form, successMessage: "Usuario actualizado correctamente!"});
        }
        // cleanValdiation("info-usuario");
        cleanValdiation("act-usuario");

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