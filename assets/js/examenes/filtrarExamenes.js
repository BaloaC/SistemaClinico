import getAll from "../global/getAll.js";
import { examenesPagination } from "./examenesPagination.js";

async function filtrarExamenes() {
    const filtro = document.getElementById("inputSearch");
    const listadoExamenes = await getAll("examenes/consulta");
    const filtrado = listadoExamenes.filter(examen => examen.nombre.match(new RegExp(filtro.value, 'i')));
    examenesPagination(filtrado);
}

window.filtrarExamenes = filtrarExamenes;