import getAll from "../global/getAll.js";
import { medicosPagination } from "./medicosPagination.js";

async function filtrarMedicos() {
    const filtro = document.getElementById("inputSearch");
    const listadoMedicos = await getAll("medicos/consulta");
    const filtrado = listadoMedicos.filter(medico => medico.nombre.match(new RegExp(filtro.value, 'i')));
    medicosPagination(filtrado);
}

window.filtrarMedicos = filtrarMedicos;