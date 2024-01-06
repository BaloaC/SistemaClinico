import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { listadoMedicosPagination, medicosPagination } from "./medicosPagination.js";

async function filtrarMedicos() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoMedicosPagination.registros.filter(medico => filterPaginationHandle(filtro, medico, ["nombre", "apellidos"]));
    
    medicosPagination(filtrado);
}

window.filtrarMedicos = filtrarMedicos;