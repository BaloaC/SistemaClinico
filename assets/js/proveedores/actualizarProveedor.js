import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import { mostrarProveedores } from "./mostrarProveedores.js";

async function updateProveedor(id) {

    const $form = document.getElementById("act-proveedor");

    try {

        const json = await getById("proveedores", id);

        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.ubicacion.value = json.ubicacion;
        $form.ubicacion.dataset.secondValue = json.ubicacion;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "proveedor_id";
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateProveedor = updateProveedor;

async function confirmUpdate() {
    const $form = document.getElementById("act-proveedor"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));
    
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.ubicacion))) throw { message: "La ubicacion ingresada no es válida" };

        const parseData = deleteSecondValue("#act-proveedor input, #act-proveedor select", data);

        await updateModule(parseData, "proveedor_id", "proveedores", "act-proveedor", "Proveedor actualizado correctamente!");
        mostrarProveedores();

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
