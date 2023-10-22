import getAll from "../global/getAll.js";
import { medicosPagination } from "./medicosPagination.js";


let listadoMedicos;

async function obtenerListadoMedicos() {
    listadoMedicos = await getAll("medicos/consulta");
}

async function filtrarMedicos() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoMedicos.filter(medico => `${medico.nombre} ${medico.apellidos}`.match(new RegExp(filtro.value, 'i')));
    medicosPagination(filtrado);
}

await obtenerListadoMedicos();

// Actualizar el listado cada 60 segundos
window.setInterval(obtenerListadoMedicos, 60000);

window.filtrarMedicos = filtrarMedicos;