import deleteModule from "../global/deleteModule.js";
import { mostrarEmpresas } from "./mostrarEmpresas.js";

async function deleteEmpresa(id){
    await deleteModule("empresas",id,"Empresa eliminada exitosamente!");
    mostrarEmpresas();
}

window.deleteEmpresa = deleteEmpresa;