import deleteSecondValue from "../global/deleteSecondValue.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import updateModule from "../global/updateModule.js";
import { mostrarSeguros } from "./mostrarSeguros.js";
import { segurosPagination } from "./segurosPagination.js";

async function updateSeguro(id) {
    const $form = document.getElementById("act-seguro");

    try {

        const json = await getById("seguros", id);

        // Obtener código telefónico
        let $telCod = json.telefono.slice(0, 4),
            $tel = json.telefono.split($telCod);

        //Separar el rif
        let $rif = json.rif.split('-');

        for (const option of $form.cod_tel.options) {
            if (option.value === $telCod) {
                option.defaultSelected = true;
            }
        }

        for (const option of $form.cod_rif.options) {
            if (option.value === $rif[0]) {
                option.defaultSelected = true;
            }
        }

        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.rif.value = $rif[1];
        $form.rif.dataset.secondValue = $rif[1];
        $form.cod_rif.dataset.secondValue = $rif[0];
        $form.direccion.value = json.direccion;
        $form.direccion.dataset.secondValue = json.direccion;
        $form.telefono.value = $tel[1];
        $form.telefono.dataset.secondValue = $tel[1];
        $form.cod_tel.dataset.secondValue = $telCod;
        $form.tipo_seguro.value = json.tipo_seguro;
        $form.tipo_seguro.dataset.secondValue = json.tipo_seguro;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "seguro_id";
        $form.appendChild($inputId);

    } catch (error) {

        alert(error);
    }
}

window.updateSeguro = updateSeguro;


async function confirmUpdate() {
    const $form = document.getElementById("act-seguro"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };
        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        // if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length !== 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length !== 4) throw { message: "El número ingresado no es válido" };

        let $tel = data.cod_tel + data.telefono,
            $rif = data.cod_rif + "-" + data.rif;

        const parseData = deleteSecondValue("#act-seguro input, #act-seguro select", data)

        // ** Si no existe rif o cod_rif en la data, añadirle el rif completo
        if ('rif' in parseData || 'cod_rif' in parseData) { parseData.rif = $rif }

        // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
        if ('telefono' in parseData || 'cod_tel' in parseData) { parseData.telefono = $tel }

        await updateModule(parseData, "seguro_id", "seguros", "act-seguro", "Seguro actualizado correctamente");
        const listadoSeguros = await getAll("seguros/consulta");
        segurosPagination(listadoSeguros);

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
document.getElementById("act-seguro").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdate();
})