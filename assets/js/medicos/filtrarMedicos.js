import { buscarRegistrosObj, medicosPagination, ssrMedicosPagination } from "./medicosPagination.js";

async function filtrarMedicos() {
    const filtro = document.getElementById("inputSearch");
    const listadoMedicos = await ssrMedicosPagination(1, `=${filtro.value}`);
    buscarRegistrosObj.valor = `=${filtro.value}`;

    medicosPagination(listadoMedicos, `=${filtro.value}`);
}

window.filtrarMedicos = filtrarMedicos;