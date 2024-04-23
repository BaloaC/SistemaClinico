import { buscarRegistrosObj, examenesPagination, ssrExamanesRequest } from "./examenesPagination.js";


async function filtrarExamenes() {

    const filtro = document.getElementById("inputSearch");
    const listadoExamanes = await ssrExamanesRequest(1, `=${filtro.value}`);
    buscarRegistrosObj.valor = `=${filtro.value}`;
    
    examenesPagination(listadoExamanes, `=${filtro.value}`);
}

window.filtrarExamenes = filtrarExamenes;