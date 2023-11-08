import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";
import { mostrarProveedores } from "./mostrarProveedores.js";
import { proveedoresPagination } from "./proveedoresPagination.js";

async function addProveedor() {

    const $form = document.getElementById("info-proveedor"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 6) throw { message: "El nombre debe contener al menos 6 caracteres" };
        if (!(patterns.nameCompany.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.address.test(data.ubicacion))) throw { message: "La ubicación ingresada no es válida" };

        await addModule("proveedores", "info-proveedor", data, "Proveedor registrado exitosamente!");

        const listadoProveedores = await getAll("proveedores/consulta");
        const registros = listadoProveedores;
        cleanValdiation("info-proveedor");
        proveedoresPagination(registros);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addProveedor = addProveedor;
document.getElementsByName('ubicacion')[0].addEventListener('keydown', (event) => {
    if (event.key == 'Enter') {
        event.preventDefault();
        addProveedor();
    }
})



