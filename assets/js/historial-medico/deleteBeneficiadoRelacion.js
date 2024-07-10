import deleteModule from "../global/deleteModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

function deleteBeneficiadoRelacion(id) {
    document.getElementById("btn-confirmDeleteBeneficiadoRelacion").setAttribute("onclick",`confirmBeneficiadoRelacion(${id})`)
}

async function confirmBeneficiadoRelacion(id){
    const idPaciente = location.pathname.split("/")[4];
    await deleteModule("beneficiado", id, "La relación con el beneficiado ha sido eliminada exitosamente!", "#modalDeleteBeneficiadoRelacion", "delAlertBeneficiadoRelacion");
    mostrarHistorialMedico(idPaciente, false);
}

window.deleteBeneficiadoRelacion = deleteBeneficiadoRelacion;
window.confirmBeneficiadoRelacion = confirmBeneficiadoRelacion;