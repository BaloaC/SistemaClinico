import mostrarHisotialMedico from "./mostrarHistorialMedico";

export default async function refreshHistorial(id){

    const antecedenteContainer = document.querySelector(".antecedente-container");
    const consultaContainer = document.getElementById("consultaAccordion");

    mostrarHisotialMedico(id);
}

