import concatItems from "../global/concatItems.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
removeAddAccountant();
removeAddAnalist();

const id = location.pathname.split("/")[4];

export default async function mostrarPerfilMedico(id) {
    try {

        const rol = Cookies.get("rol");

        const cedula = document.getElementById("cedula_medico");
        const nombre = document.getElementById("nombre_medico");
        const telefono = document.getElementById("telefono");
        const direccion = document.getElementById("direccion");
        const acumulado = document.getElementById("acumulado");
        const tipo_paciente = document.getElementById("tipo_paciente");
        const citaContainer = document.getElementById("citaAccordion");
        const templateCita = document.getElementById("template-cita").content;
        const citaFragment = document.createDocumentFragment();

        const infoMedico = await getById("medicos", id);

        console.log(infoMedico)

        cedula.textContent = infoMedico[0].cedula;
        nombre.textContent = `${infoMedico[0].nombre} ${infoMedico[0].apellidos}`;
        telefono.textContent = infoMedico[0].telefono;
        direccion.textContent = infoMedico[0].direccion;
        acumulado.textContent = infoMedico[0].acumulado;
    

        // ** Validamos en caso de que el paciente tenga citas pendientes
        // if (listCita.length > 0) {

        //     const citasLabel = document.getElementById("citasLabel");
        //     citasLabel.classList.remove("d-none");

        //     // !! En caso de que se necesite mostrar más citas
        //     // listCitas.forEach((el, i) => {

        //         let dropdownLink = templateCita.querySelector(".btn-link");
        //         let citaContainer = templateCita.querySelector(".collapse");
        //         let cita_id = templateCita.getElementById("cita_id");
        //         let nombre_medico = templateCita.getElementById("nombre_medico");
        //         let especialidad = templateCita.getElementById("especialidad");
        //         let fecha_cita = templateCita.getElementById("fecha_cita");
        //         let motivo_cita = templateCita.getElementById("motivo_cita");
        //         let hora_entrada = templateCita.getElementById("hora_entrada");
        //         let hora_salida = templateCita.getElementById("hora_salida");
        //         let tipo_cita = templateCita.getElementById("tipo_cita");
        //         let estatus_cit = templateCita.getElementById("estatus_cit");

        //         // ! En caso de que se necesite mostrar más citas
        //         // if (i === 0) {
        //             citaContainer.classList.add("show");
        //         // } else {
        //         //     citaContainer.classList.remove("show");
        //         // }

        //         cita_id.textContent = listCita.cita_id;
        //         nombre_medico.textContent = `${listCita.nombre_medico} ${listCita.apellido_medico}`;
        //         especialidad.textContent = listCita.nombre_especialidad;
        //         fecha_cita.textContent = listCita.fecha_cita;
        //         motivo_cita.textContent = listCita.motivo_cita;
        //         hora_entrada.textContent = listCita.hora_entrada;
        //         hora_salida.textContent = listCita.hora_salida;
        //         tipo_cita.textContent = listCita.tipo_cita === "2" ? "Asegurada" : "Natural";
        //         estatus_cit.textContent = listCita.estatus_cit === "3" ? "Pendiente" : "Asignada";
                

        //         dropdownLink.innerHTML = `<b>ID:</b> ${cita_id.textContent} - <b>Nombre médico:</b> ${nombre_medico.textContent} - <b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_cita.textContent}`;
        //         dropdownLink.setAttribute("data-bs-target", `#cita-${listCita.cita_id}`);
        //         dropdownLink.setAttribute("aria-controls", `#cita-${listCita.cita_id}`);
        //         citaContainer.setAttribute("id", `cita-${listCita.cita_id}`);

        //         let clone = document.importNode(templateCita, true);
        //         citaFragment.appendChild(clone);
        //     // });

        //     // Actualizamos el contenedor e insertamos los datos
        //     citaContainer.replaceChildren();
        //     citaContainer.appendChild(citaFragment);

        // }

    } catch (error) {
        console.log(error);
    }
}

window.mostrarPerfilMedico = mostrarPerfilMedico;

document.addEventListener("DOMContentLoaded", async () => {

    const urlParams = new URLSearchParams(window.location.search);
    const medico_id = urlParams.get('medico');

    await mostrarPerfilMedico(medico_id);
})
