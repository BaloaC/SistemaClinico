import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import getAll from "../global/getAll.js";
import { proveedoresPagination } from "./proveedoresPagination.js";
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

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        // if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.ubicacion))) throw { message: "La ubicación ingresada no es válida" };

        const parseData = deleteSecondValue("#act-proveedor input, #act-proveedor select", data);

        await updateModule(parseData, "proveedor_id", "proveedores", "act-proveedor", "Proveedor actualizado correctamente!");
        const listadoProveedores = await getAll("proveedores/consulta");
        const registros = listadoProveedores;
        proveedoresPagination(registros);

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
