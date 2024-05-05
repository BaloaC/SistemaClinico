import { getConsultasAseguradas } from "./consultasAseguradas.js";
import { getAllConsultasEspecialidades } from "./consultasEspecialidad.js";
import { getMedicoConsulta } from "./medicoConsulta.js";
import { getPacientesByAge } from "./pacienteEdad.js";
import { getPacientesByType } from "./pacienteTipo.js";

async function consultasByRangeOfDate(startDate, endDate) {

    const loadingMessageMedicoConsulta = document.querySelector(".medicoConsulta.loading");
    const loadingMessageConsultaAsegurada = document.querySelector(".consultasAseguradas.loading");
    const loadingMessageConsultaEspecialidad = document.querySelector(".consultasEspecialidad.loading");

    // Removemos el mensaje de cargando para que aparezcan al mismo tiempo
    loadingMessageConsultaEspecialidad.classList.remove("d-none");
    loadingMessageConsultaAsegurada.classList.remove("d-none");
    loadingMessageMedicoConsulta.classList.remove("d-none");

    await getMedicoConsulta(startDate, endDate);
    await getConsultasAseguradas(startDate, endDate);
    await getAllConsultasEspecialidades(startDate, endDate);
}

async function pacientesByRanfeOfAge(startRange, endRange) {

    const loadingMessagePacienteEdad = document.querySelector(".pacienteEdad.loading");
    const loadingMessagePacienteTipo = document.querySelector(".pacienteTipo.loading");
    
    // Removemos el mensaje de cargando para que aparezcan al mismo tiempo
    loadingMessagePacienteEdad.classList.remove("d-none");
    loadingMessagePacienteTipo.classList.remove("d-none");

    await getPacientesByAge(startRange, endRange);
    await getPacientesByType(startRange, endRange);
}

async function graphFilterHandler() {

    const filtro = document.getElementById("filterSelect").value;

    // ** Tal vez solos podamos avanzar más rápido, pero juntos llegaremos más lejos

    // Filtrar pacientes por edad
    if (filtro === "1") {

        const startRange = document.querySelector(".containerFiltroPacienteEdad #startRange");
        const endRange = document.querySelector(".containerFiltroPacienteEdad #endRange");

        pacientesByRanfeOfAge(startRange.value, endRange.value);

    } else if (filtro === "2") { // Filtrar las consultas

        const startDate = document.querySelector(".containerFiltroConsultaFecha #startDate");
        const endDate = document.querySelector(".containerFiltroConsultaFecha #endDate");

        consultasByRangeOfDate(startDate.value, endDate.value);
    }
}


async function inputGraphFilterHandler(input) {

    const filterBtn = document.getElementById("filterBtn");
    const containerFiltroPacienteEdad = document.querySelector(".containerFiltroPacienteEdad");
    const containerFiltroConsultaFecha = document.querySelector(".containerFiltroConsultaFecha");

    if (input.value === "0") {

        // Ocultamos cualquier filtro
        $(containerFiltroConsultaFecha).fadeOut("slow");
        $(containerFiltroPacienteEdad).fadeOut("slow");

        // Ocultamos el botón del filtrado
        $(filterBtn).fadeOut("slow")

        // Reiniciamos todas las gráficas
        await getPacientesByAge();
        await getPacientesByType();
        await getAllConsultasEspecialidades();
        await getConsultasAseguradas();
        await getMedicoConsulta();

    } else if (input.value === "1") {

        // Ocultamos cualquier filtro
        $(containerFiltroConsultaFecha).fadeOut("slow");

        // Mostramos el filtro seleccionado
        $(containerFiltroPacienteEdad).fadeIn("slow");

        // Mostramos el botón del filtrado
        $(filterBtn).fadeIn("slow")

    } else if (input.value === "2") {

        // Ocultamos cualquier filtro
        $(containerFiltroPacienteEdad).fadeOut("slow");

        // Mostramos el filtro seleccionado
        $(containerFiltroConsultaFecha).fadeIn("slow");

        // Mostramos el botón del filtrado
        $(filterBtn).fadeIn("slow")
    }
}

window.inputGraphFilterHandler = inputGraphFilterHandler;
window.graphFilterHandler = graphFilterHandler;