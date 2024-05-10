import getAll from "../global/getAll.js";

class VistaLaboratorio {
    constructor() {
        this.abecedarioContenedor = document.querySelector('[data-identifier="abecedarioLista"]');
        this.examenesLista = "";
        this.abecedarioLista = "";

        this.obtenerExamenes();
        
        const observer = new MutationObserver(() => {
            document.querySelectorAll('[data-action="mostrarLaboratorios"]').forEach(element => {
                element.addEventListener('click', (e) => this.mostrarLaboratorios(element.getAttribute('data-abecedario')))
            });
        });
        observer.observe(this.abecedarioContenedor, { characterData: true, subtree: true, childList: true });
    }

    async obtenerExamenes() {
        this.examenesLista = await getAll("examenes/laboratorios");
        const abecedario = this.examenesLista.map(function (examen) {
            return examen.nombre.charAt(0);
        });

        this.abecedarioLista = [...new Set(abecedario)];
        this.abecedarioLista.sort();

        this.mostrarAbecedario();
    }

    async mostrarAbecedario() {
        let letras = [];
        this.abecedarioLista.forEach((abecedario) => {

            let clase = this.abecedarioLista.indexOf(abecedario) == 0 ? 'active-word' : '';

            letras.push(`<a class="${abecedario} ${clase}" data-action="mostrarLaboratorios" data-abecedario="${abecedario}">${abecedario.toUpperCase()}</a>`)
            letras.push(` - `);
        });

        letras.pop();
        this.abecedarioContenedor.innerHTML = letras.join('');
        this.mostrarLaboratorios(this.abecedarioLista[0]);
    }

    async mostrarLaboratorios(inicial) {
        let inicialMayuscula = inicial.toLowerCase();
        const laboratoriosList = this.examenesLista.filter(examen => examen.nombre.toLowerCase().slice("0")[0] === inicialMayuscula);
        const examenesContainer = document.querySelector(".examenes-list");
        let template = "";

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
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    new VistaLaboratorio();

})