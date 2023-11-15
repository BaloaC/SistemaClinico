import getAll from "../global/getAll.js";

async function mostrarLaboratorios(inicial) {
    
    try {

        let template = "";
        const examenesContainer = document.querySelector(".examenes-list");
        const examenesList = await getAll("examenes/laboratorios");

        const laboratoriosList = examenesList.filter(examen => examen.nombre.toLowerCase().slice("0")[0] === inicial);

        // Seleccionar la letra activa
        const activeWord = document.querySelector(".active-word");
        const initialAbc = document.querySelector(`.${inicial}`);
        activeWord.classList.remove("active-word");
        initialAbc.classList.add("active-word");

        if(laboratoriosList && laboratoriosList?.length > 0){

            template = `<h2 class="initial">${inicial.toUpperCase()}</h2>`;
            template += `<ul class="ul-examenes">`;

            laboratoriosList.forEach(laboratorio => {
                template += `<li>${laboratorio.nombre}</li> <hr>`;
            });

            template += `</ul>`

            examenesContainer.innerHTML = template;

            // Para eliminar el último hr
            const laboratorios = document.querySelector(".ul-examenes");
            laboratorios.removeChild(laboratorios.lastElementChild);
        } else {

            template = `<h4 class="initial">${inicial.toUpperCase()}</h4>`;
            template += `<h5 class="mx-5">No se encontraron exámenes de laboratorio</h5>`;
            examenesContainer.innerHTML = template;
        }
        
    } catch (error) {

        console.log(error);
    }
}

window.mostrarLaboratorios = mostrarLaboratorios;

document.addEventListener("DOMContentLoaded", async () => {
    mostrarLaboratorios("a");
})