import dinamicSelect from "../global/dinamicSelect.js";
import listarSeguros, { listarSegurosPorId } from "../seguros/listarSeguros.js";
import listarEmpresas, { listarEmpresaPorId } from "./listarEmpresas.js";
import listarMedicos from "./listarMedicos.js";

const d = document,
    path = location.pathname.split('/');

async function getMedico(id) {
    try {

        const $nombreEmpresa = d.getElementById("nombreEmpresa"),
            $rifEmpresa = d.getElementById("rifEmpresa"),
            $nombreSeguro = d.getElementById("nombreSeguro"),
            $direcEmpresa = d.getElementById("direcEmpresa"),
            $btnActualizar = d.getElementById("btn-actualizar"),
            $btnEliminar = d.getElementById("btn-confirmDelete");

        const json = await listarEmpresaPorId(id);

        $nombreEmpresa.innerText = `${json[0].nombre_empresa}`;
        $rifEmpresa.innerText = `${json[0].rif}`;
        $direcEmpresa.innerText = `${json[0].direccion}`;
        $nombreSeguro.innerText = `${json[0].nombre}`;
        $btnActualizar.value = id;
        $btnEliminar.value = id;

    } catch (error) {

        alert(error);
    }
}

window.getMedico = getMedico;

export async function mostrarMedicos() {

    try {

        const listadoMedicos = await listarMedicos(),
            $cardTemplate = d.getElementById("card-template").content,
            $medicosContainer = d.getElementById("medicos-container"),
            $fragment = d.createDocumentFragment();

        
        listadoMedicos.forEach(el => {

            let $nombreEmpresa = $cardTemplate.querySelector("h3"),
                $cardContainer = $cardTemplate.querySelector(".card-container"),
                $rif = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
                $nombreSeguro = $cardTemplate.querySelector(".list-group > li:nth-child(2) > b");

            $nombreEmpresa.textContent = el.nombre_empresa;
            $rif.textContent = el.rif;
            $nombreSeguro.textContent = el.nombre;
            $cardContainer.setAttribute("onclick", `getEmpresa(${el.empresa_id})`);

            let clone = document.importNode($cardTemplate, true);
            $fragment.appendChild(clone);
        })

        $empresasContainer.replaceChildren();
        $empresasContainer.appendChild($fragment);

    } catch (error) {
        console.log(error);
    }
}

d.addEventListener("DOMContentLoaded", e => {
    mostrarMedicos();
});

d.addEventListener("click", async function (e) {

    if (e.target.matches("#seguro_id") && e.target.dataset.active == 0) {

        const seguros = await listarSeguros();
        dinamicSelect(seguros, "nombre", "seguro_id", e.target);
        e.target.dataset.active = 1;
    }
})