import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import listarSeguros, { listarSegurosPorId } from "./listarSeguros.js";


async function getSeguro(id) {
    try {

        const $nombreSeguro = document.getElementById("nombreSeguro"),
            $rifSeguro = document.getElementById("rifSeguro"),
            $direcSeguro = document.getElementById("direcSeguro"),
            $telSeguro = document.getElementById("telSeguro"),
            $porcSeguro = document.getElementById("porcSeguro"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");

        const json = await getById("seguros", id),
            tipoSeguroNombre = ["Acumulativo", "Normal"];

        $nombreSeguro.innerText = `${json.nombre}`;
        $rifSeguro.innerText = `${json.rif}`;
        $direcSeguro.innerText = `${json.direccion}`;
        $telSeguro.innerText = `${json.telefono}`;
        $btnActualizar.setAttribute("onclick", `updateSeguro(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteSeguro(${id})`);

    } catch (error) {

        alert(error);
    }
}

window.getSeguro = getSeguro;