import addModule from "../global/addModule.js";
import getAll from "../global/getAll.js";
import { mostrarSeguros } from "./mostrarSeguros.js";
import { segurosPagination } from "./segurosPagination.js";

async function addSeguro() {
    const $form = document.getElementById("info-seguro"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length !== 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length !== 4) throw { message: "El número ingresado no es válido" };

        data.telefono = data.cod_tel + data.telefono;
        data.rif = data.cod_rif + "-" + data.rif;

        await addModule("seguros", "info-seguro", data, "Seguro registrado exitosamente!")
        const listadoSeguros = await getAll("seguros/consulta");
        segurosPagination(listadoSeguros);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addSeguro = addSeguro;