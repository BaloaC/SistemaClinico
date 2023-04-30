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
            $tipoSeguro = document.getElementById("tipoSeguro"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");

        const json = await getById("seguros", id),
            tipoSeguroNombre = ["Acumulativo", "Normal"];

        $nombreSeguro.innerText = `${json.nombre}`;
        $rifSeguro.innerText = `${json.rif}`;
        $direcSeguro.innerText = `${json.direccion}`;
        $telSeguro.innerText = `${json.telefono}`;
        $tipoSeguro.innerText = `${tipoSeguroNombre[json.tipo_seguro - 1]}`;
        $btnActualizar.setAttribute("onclick", `updateSeguro(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteSeguro(${id})`);

    } catch (error) {

        alert(error);
    }
}

window.getSeguro = getSeguro;

export async function mostrarSeguros() {

    //     try {

    //         const listadoSeguros = await getAll("seguros/consulta"),
    //             $cardTemplate = document.getElementById("card-template").content,
    //             $segurosContainer = document.getElementById("seguros-container"),
    //             $fragment = document.createDocumentFragment();

    //         listadoSeguros.forEach(el => {

    //             let $nombreSeguro = $cardTemplate.querySelector("h3"),
    //                 $cardContainer = $cardTemplate.querySelector(".card-container"),
    //                 $rif = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
    //                 $telefono = $cardTemplate.querySelector(".list-group > li:nth-child(2) > b");

    //             $nombreSeguro.textContent = el.nombre;
    //             $rif.textContent = el.rif;
    //             $telefono.textContent = el.telefono;
    //             $cardContainer.setAttribute("onclick", `getSeguro(${el.seguro_id})`);

    //             let clone = document.importNode($cardTemplate, true);
    //             $fragment.appendChild(clone);
    //         })

    //         $segurosContainer.replaceChildren();
    //         $segurosContainer.appendChild($fragment);

    //     } catch (error) {
    //         console.log(error);
    //     }
}

// addEventListener("DOMContentLoaded", mostrarSeguros);