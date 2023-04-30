import getAll from "../global/getAll.js";
import { empresasPagination } from "./empresasPagination.js";

async function filtrarEmpresas() {
    const filtro = document.getElementById("inputSearch");
    const listadoEmpresas = await getAll("empresas/consulta");
    const filtrado = listadoEmpresas.filter(empresa => empresa.nombre.match(new RegExp(filtro.value, 'i')));
    empresasPagination(filtrado);
}

window.filtrarEmpresas = filtrarEmpresas;