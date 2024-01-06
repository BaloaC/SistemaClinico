import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { examenesPagination, listadoExamenesPagination } from "./examenesPagination.js";


async function filtrarExamenes() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoExamenesPagination.registros.filter(examen => filterPaginationHandle(filtro, examen, ["nombre"]));

    examenesPagination(filtrado);
}

window.filtrarExamenes = filtrarExamenes;