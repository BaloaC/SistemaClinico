import concatItems from "../global/concatItems.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
removeAddAccountant();
removeAddAnalist();

const id = location.pathname.split("/")[4];

export default async function mostrarHistorialMedico(id) {
    try {

        const rol = Cookies.get("rol");

        const nombre = document.getElementById("nombre_paciente");
        const fecha = document.getElementById("fecha");
        const edad = document.getElementById("edad");
        const tipo_paciente = document.getElementById("tipo_paciente");
        const consultaPdf = document.getElementById("consulta-pdf");
        const seguroContainer = document.querySelector(".seguro-container");
        const templateSeguro = document.getElementById("template-seguro").content;
        const seguroFragment = document.createDocumentFragment();
        const antecedenteContainer = document.querySelector(".antecedente-container");
        const templateAntecedente = document.getElementById("template-antecedente").content;
        const antecedenteFragment = document.createDocumentFragment();
        const citaContainer = document.getElementById("citaAccordion");
        const templateCita = document.getElementById("template-cita").content;
        const citaFragment = document.createDocumentFragment();
        const consultaContainer = document.getElementById("consultaAccordion");
        const templateConsulta = document.getElementById("template-consulta").content;
        const consultaFragment = document.createDocumentFragment();

        const infoPaciente = await getById("pacientes", id);
        const infoConsultas = await getById("consultas/paciente", id);
        const listCita = await getById("citas/paciente",id);

        // ! Obtenemos las citas asigandas y las que están en espera. En caso de que se necesite mostrar más citas
        // const listCita = infoCitas.filter(cita => cita.estatus_cit === "1" || cita.estatus_cit === "3").sort((a,b) => b.cita_id - a.cita_id);

        // Obtenemos las consultas por id de manera descendente
        const listConsultas = infoConsultas.consultas.sort((a, b) => b.consulta_id - a.consulta_id);

        nombre.textContent = `${infoPaciente.nombre || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
        fecha.textContent = `${infoPaciente.fecha_nacimiento}`;
        edad.textContent = `${infoPaciente.edad}`;
    
        switch(infoPaciente.tipo_paciente){
            case "1": tipo_paciente.textContent = "Natural"; break;
            case "2": tipo_paciente.textContent = "Representante"; break;
            case "3": tipo_paciente.textContent = "Asegurado"; break;
            case "4": tipo_paciente.textContent = "Beneficiado"; break;
            default: tipo_paciente.textContent = "Desconocido"; break;
        }


        // ** Validamos si el paciente es asegurado y tiene seguros
        if(infoPaciente.tipo_paciente === "3" && infoPaciente.seguro.length > 0){

            infoPaciente.seguro.forEach(el => {

                let nombreEmpresa = templateSeguro.getElementById("nombre_empresa");
                let nombreSeguro = templateSeguro.getElementById("nombre_seguro");

                nombreEmpresa.textContent = el.nombre_empresa;
                nombreSeguro.textContent = el.nombre_seguro;

                let clone = document.importNode(templateSeguro, true);
                seguroFragment.appendChild(clone);
            });

            //Mostrarmos el label
            const seguroLabel = document.getElementById("seguroLabel");
            seguroLabel.classList.remove("d-none");

            // Actualizamos el contenedor e insertamos los datos
            seguroContainer.replaceChildren();
            seguroContainer.appendChild(seguroFragment);
        }

        // ** Validamos si el paciente cuenta con antecedetes médicos
        if (infoConsultas?.antecedentes_medicos?.length > 0) {

            infoConsultas.antecedentes_medicos.forEach(el => {

                let tipoAntecedente = templateAntecedente.getElementById("tipo_antedecente");
                let descripcionAntecedente = templateAntecedente.getElementById("descripcion_antecedente");
                let actLink = templateAntecedente.querySelector(".act-antecedente");
                let delLink = templateAntecedente.querySelector(".del-antecedente");
                let actIcon = templateAntecedente.querySelector(".fa-edit");
                let delIcon = templateAntecedente.querySelector(".fa-trash");
                
                if(rol === "1" || rol === "2" || rol === "5"){

                    actLink.setAttribute("onclick", `updateAntecedente(${el.antecedentes_medicos_id})`);
                    delLink.setAttribute("onclick", `deleteAntecedente(${el.antecedentes_medicos_id})`);
                } else {
                    actLink.setAttribute("data-bs-toggle","");
                    delLink.setAttribute("data-bs-toggle","")
                    actIcon.classList.add("d-none");
                    delIcon.classList.add("d-none");
                }


                tipoAntecedente.textContent = el.nombre;
                descripcionAntecedente.textContent = el.descripcion;

                let clone = document.importNode(templateAntecedente, true);
                antecedenteFragment.appendChild(clone);
            });

            // Actualizamos el contenedor e insertamos los datos
            antecedenteContainer.replaceChildren();
            antecedenteContainer.appendChild(antecedenteFragment);

        } else {
            const p = document.createElement("p");
            p.textContent = "El paciente no posee antecedentes médicos";

            // Actualizamos el contenedor e insertamos los datos
            antecedenteContainer.replaceChildren();
            antecedenteContainer.appendChild(p);
        }

        // ** Validamos en caso de que el paciente tenga citas pendientes
        if (listCita?.cita_id) {

            const citasLabel = document.getElementById("citasLabel");
            citasLabel.classList.remove("d-none");

            // !! En caso de que se necesite mostrar más citas
            // listCitas.forEach((el, i) => {

                let dropdownLink = templateCita.querySelector(".btn-link");
                let citaContainer = templateCita.querySelector(".collapse");
                let cita_id = templateCita.getElementById("cita_id");
                let nombre_medico = templateCita.getElementById("nombre_medico");
                let especialidad = templateCita.getElementById("especialidad");
                let fecha_cita = templateCita.getElementById("fecha_cita");
                let motivo_cita = templateCita.getElementById("motivo_cita");
                let hora_entrada = templateCita.getElementById("hora_entrada");
                let hora_salida = templateCita.getElementById("hora_salida");
                let tipo_cita = templateCita.getElementById("tipo_cita");
                let estatus_cit = templateCita.getElementById("estatus_cit");

                // ! En caso de que se necesite mostrar más citas
                // if (i === 0) {
                    citaContainer.classList.add("show");
                // } else {
                //     citaContainer.classList.remove("show");
                // }

                cita_id.textContent = listCita.cita_id;
                nombre_medico.textContent = `${listCita.nombre_medico} ${listCita.apellido_medico}`;
                especialidad.textContent = listCita.nombre_especialidad;
                fecha_cita.textContent = listCita.fecha_cita;
                motivo_cita.textContent = listCita.motivo_cita;
                hora_entrada.textContent = listCita.hora_entrada;
                hora_salida.textContent = listCita.hora_salida;
                tipo_cita.textContent = listCita.tipo_cita === "2" ? "Asegurada" : "Natural";
                estatus_cit.textContent = listCita.estatus_cit === "3" ? "Pendiente" : "Asignada";
                

                dropdownLink.innerHTML = `<b>ID:</b> ${cita_id.textContent} - <b>Nombre médico:</b> ${nombre_medico.textContent} - <b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_cita.textContent}`;
                dropdownLink.setAttribute("data-bs-target", `#cita-${listCita.cita_id}`);
                dropdownLink.setAttribute("aria-controls", `#cita-${listCita.cita_id}`);
                citaContainer.setAttribute("id", `cita-${listCita.cita_id}`);

                let clone = document.importNode(templateCita, true);
                citaFragment.appendChild(clone);
            // });

            // Actualizamos el contenedor e insertamos los datos
            citaAccordion.replaceChildren();
            citaAccordion.appendChild(citaFragment);

        }


        // ** Validación en caso de que el paciente tenga consultas registradas
        if (listConsultas.length > 0) {

            consultaPdf.classList.remove("d-none");
            consultaPdf.setAttribute("onclick", `openPopup('pdf/historialmedico/${id}')`);

            listConsultas.forEach((el, i) => {

                let dropdownLink = templateConsulta.querySelector(".btn-link");
                let consultaContainer = templateConsulta.querySelector(".collapse");
                let consulta_id = templateConsulta.getElementById("consulta_id");
                let nombre_medico = templateConsulta.getElementById("nombre_medico");
                let especialidad = templateConsulta.getElementById("especialidad");
                let fecha_consulta = templateConsulta.getElementById("fecha_consulta");
                let motivo_cita = templateConsulta.getElementById("motivo_cita");
                let indicaciones = templateConsulta.getElementById("indicaciones");
                let observaciones = templateConsulta.getElementById("observaciones");

                if (i === 0) {
                    consultaContainer.classList.add("show");
                } else {
                    consultaContainer.classList.remove("show");
                }

                consulta_id.textContent = el.consulta_id;
                nombre_medico.textContent = `${el.nombre_medico} ${el.apellidos_medico}`;
                especialidad.textContent = el.nombre_especialidad;
                fecha_consulta.textContent = el.fecha_consulta;
                observaciones.textContent = el.observaciones || "Sin observaciones";
                motivo_cita.textContent = el.motivo_cita;
                indicaciones.textContent = el.indicaciones !== undefined ? concatItems(el.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";

                dropdownLink.innerHTML = `<b>ID:</b> ${consulta_id.textContent} - <b>Nombre médico:</b> ${nombre_medico.textContent} - <b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_consulta.textContent}`;
                dropdownLink.setAttribute("data-bs-target", `#consulta-${el.consulta_id}`);
                dropdownLink.setAttribute("aria-controls", `#consulta-${el.consulta_id}`);
                consultaContainer.setAttribute("id", `consulta-${el.consulta_id}`);

                let clone = document.importNode(templateConsulta, true);
                consultaFragment.appendChild(clone);
            });

            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(consultaFragment);

        } else {
            consultaPdf.classList.add("d-none");
            const h6 = document.createElement("h6");
            h6.textContent = "El paciente no posee consultas";

            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(h6);
        }
    } catch (error) {
        console.log(error);
    }
}

window.mostrarHistorialMedico = mostrarHistorialMedico;

document.addEventListener("DOMContentLoaded", async () => {
    await mostrarHistorialMedico(id);
})
