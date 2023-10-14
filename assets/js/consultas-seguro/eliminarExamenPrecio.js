import deleteModule from "../global/deleteModule.js";
import { getConsultasSegurosMes } from "./mostrarConsultaSeguro.js";

function deletePrecioExamen(id, seguro) {
    document.getElementById("btn-confirmDeleteExamenPrecio").setAttribute("onclick",`confirmDeleteExamenPrecio(${id.value}, ${seguro})`);
}

async function confirmDeleteExamenPrecio(examen_id,seguro){
    await deleteModule("seguros/examen", seguro, "Precio del examen eliminado exitosamente!", "#modalDeletePrecioExamen", "delAlertPrecioExamen", {examen_id});
    await getConsultasSegurosMes({seguro});
}

window.deletePrecioExamen = deletePrecioExamen;
window.confirmDeleteExamenPrecio = confirmDeleteExamenPrecio;