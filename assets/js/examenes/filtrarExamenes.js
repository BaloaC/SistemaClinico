import getAll from "../global/getAll.js";
import { examenesPagination } from "./examenesPagination.js";

let listadoExamenes;

async function obtenerListadoExamenes() {
    listadoExamenes = await getAll("examenes/consulta");
}

async function filtrarExamenes() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoExamenes.filter(examen => examen.nombre.match(new RegExp(filtro.value, 'i')));
    examenesPagination(filtrado);
}

await obtenerListadoExamenes();

// Actualizar el listado cada 60 segundos
window.setInterval(obtenerListadoExamenes, 60000);

window.filtrarExamenes = filtrarExamenes;