import {mostrarSeguros} from "./mostrarSeguros.js";
import deleteModule from "../global/deleteModule.js";

async function deleteSeguro(id){
    await deleteModule("seguros",id,"Seguro eliminado exitosamente!");
    mostrarSeguros();
}

window.deleteSeguro = deleteSeguro;