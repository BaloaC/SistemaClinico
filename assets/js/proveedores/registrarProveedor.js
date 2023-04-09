import addModule from "../global/addModule.js";
import { mostrarProveedores } from "./mostrarProveedores.js";

async function addProveedor() {
    
    const $form = document.getElementById("info-proveedor"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.ubicacion))) throw { message: "La ubicación ingresada no es válida" };

        await addModule("proveedores", "info-proveedor", data, "Proveedor registrado exitosamente!");
        mostrarProveedores();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addProveedor = addProveedor;

