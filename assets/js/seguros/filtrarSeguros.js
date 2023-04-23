import getAll from "../global/getAll.js";
import { segurosPagination } from "./segurosPagination.js";

async function filtrarSeguros() {
    const filtro = document.getElementById("inputSearch");
    const listadoSeguros = await getAll("seguros/consulta");
    const filtrado = listadoSeguros.filter(seguro => seguro.nombre.match(new RegExp(filtro.value, 'i')));
    segurosPagination(filtrado);
}

window.filtrarSeguros = filtrarSeguros;