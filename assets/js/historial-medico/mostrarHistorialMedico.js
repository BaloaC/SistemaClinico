import concatItems from "../global/concatItems.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
import formatToRealDate from "../global/formatToRealDate.js";
removeAddAccountant();
removeAddAnalist();

const id = location.pathname.split("/")[4];

export default async function mostrarHistorialMedico(id, updateAntecedente = false) {
    try {

        const rol = Cookies.get("rol");

        const nombre = document.getElementById("nombre_paciente");
        const fecha = document.getElementById("fecha");
        const edad = document.getElementById("edad");
        const cedulaPaciente = document.getElementById("cedulaPaciente");
        const telefonoPaciente = document.getElementById("telefonoPaciente");
        const direccionPaciente = document.getElementById("direccionPaciente");
        const tipo_paciente = document.getElementById("tipo_paciente");
        const consultaPdf = document.getElementById("consulta-pdf");
        const seguroContainer = document.querySelector(".seguro-container");
        const templateSeguro = document.getElementById("template-seguro").content;
        const seguroFragment = document.createDocumentFragment();
        const antecedenteContainer = document.querySelector(".antecedente-container");
        const beneficiadoContainer = document.querySelector(".beneficiado-container");
        const templateBeneficiado = document.getElementById("template-beneficiado").content;
        const beneficiadoFragment = document.createDocumentFragment();
        const titularContainer = document.querySelector(".titular-container");
        const templateTitular = document.getElementById("template-titular").content;
        const titularFragment = document.createDocumentFragment();
        const templateAntecedente = document.getElementById("template-antecedente").content;
        const antecedenteFragment = document.createDocumentFragment();
        const citaContainer = document.getElementById("citaAccordion");
        const templateCita = document.getElementById("template-cita").content;
        const citaFragment = document.createDocumentFragment();
        const consultaContainer = document.getElementById("consultaAccordion");
        const templateConsulta = document.getElementById("template-consulta").content;
        const consultaFragment = document.createDocumentFragment();

        const infoConsultas = await getById("consultas/paciente", id)

        // ** Validamos si el paciente cuenta con antecedetes médicos
        if (infoConsultas?.antecedentes_medicos?.length > 0) {

            infoConsultas.antecedentes_medicos.forEach(el => {

                let tipoAntecedente = templateAntecedente.getElementById("tipo_antedecente");
                let descripcionAntecedente = templateAntecedente.getElementById("descripcion_antecedente");
                let actLink = templateAntecedente.querySelector(".act-antecedente");
                let delLink = templateAntecedente.querySelector(".del-antecedente");
                let actIcon = templateAntecedente.querySelector(".fa-edit");
                let delIcon = templateAntecedente.querySelector(".fa-trash");

                if (rol === "1" || rol === "2" || rol === "5") {

                    actLink.setAttribute("onclick", `updateAntecedente(${el.antecedentes_medicos_id})`);
                    delLink.setAttribute("onclick", `deleteAntecedente(${el.antecedentes_medicos_id})`);
                } else {
                    actLink.setAttribute("data-bs-toggle", "");
                    delLink.setAttribute("data-bs-toggle", "")
                    actIcon.classList.add("d-none");
                    delIcon.classList.add("d-none");
                }


                tipoAntecedente.textContent = el.nombre;
                descripcionAntecedente.textContent = el.descripcion;

                let clone = document.importNode(templateAntecedente, true);
                antecedenteFragment.appendChild(clone);
            });

            const antecedenteContainerHidded = document.getElementById("antecedenteContainer");
            antecedenteContainerHidded.classList.remove("d-none");
            antecedenteContainerHidded.classList.remove("invisible");

            // Actualizamos el contenedor e insertamos los datos
            antecedenteContainer.replaceChildren();
            antecedenteContainer.appendChild(antecedenteFragment);

        } else {

            // Ocultamos el container
            const antecedenteContainer = document.getElementById("antecedenteContainer");
            antecedenteContainer.classList.add("d-none");
            antecedenteContainer.classList.add("invisible");
        }

        // // ** Validamos si el paciente cuenta con antecedetes médicos
        // if (infoConsultas?.antecedentes_medicos?.length > 0) {

        //     infoConsultas.antecedentes_medicos.forEach(el => {

        //         let tipoAntecedente = templateAntecedente.getElementById("tipo_antedecente");
        //         let descripcionAntecedente = templateAntecedente.getElementById("descripcion_antecedente");
        //         let actLink = templateAntecedente.querySelector(".act-antecedente");
        //         let delLink = templateAntecedente.querySelector(".del-antecedente");
        //         let actIcon = templateAntecedente.querySelector(".fa-edit");
        //         let delIcon = templateAntecedente.querySelector(".fa-trash");

        //         if (rol === "1" || rol === "2" || rol === "5") {

        //             actLink.setAttribute("onclick", `updateAntecedente(${el.antecedentes_medicos_id})`);
        //             delLink.setAttribute("onclick", `deleteAntecedente(${el.antecedentes_medicos_id})`);
        //         } else {
        //             actLink.setAttribute("data-bs-toggle", "");
        //             delLink.setAttribute("data-bs-toggle", "")
        //             actIcon.classList.add("d-none");
        //             delIcon.classList.add("d-none");
        //         }


        //         tipoAntecedente.textContent = el.nombre;
        //         descripcionAntecedente.textContent = el.descripcion;

        //         let clone = document.importNode(templateAntecedente, true);
        //         antecedenteFragment.appendChild(clone);
        //     });

        //     const antecedenteContainerHidded = document.getElementById("antecedenteContainer");
        //     antecedenteContainerHidded.classList.remove("d-none");
        //     antecedenteContainerHidded.classList.remove("invisible");

        //     // Actualizamos el contenedor e insertamos los datos
        //     antecedenteContainer.replaceChildren();
        //     antecedenteContainer.appendChild(antecedenteFragment);

        // } else {

        //     // Ocultamos el container
        //     const antecedenteContainer = document.getElementById("antecedenteContainer");
        //     antecedenteContainer.classList.add("d-none");
        //     antecedenteContainer.classList.add("invisible");
        // }

        // Validamos que si es solo actualizar los antecedentes dejamos de hacer las demás solicitudes
        if(updateAntecedente === true) return;



        const infoPaciente = await getById("pacientes", id);
        const listCita = await getById("citas/paciente", id);

        // Obtenemos las consultas por id de manera descendente
        const listConsultas = infoConsultas.consultas;

        nombre.textContent = `${infoPaciente.nombre || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
        fecha.textContent = `${formatToRealDate(infoPaciente.fecha_nacimiento)}`;
        edad.textContent = `${infoPaciente.edad}`;
        telefonoPaciente.textContent = `${infoPaciente.telefono}`;
        direccionPaciente.textContent = `${infoPaciente.direccion}`;
        cedulaPaciente.textContent = `${infoPaciente.cedula}`;

        switch (infoPaciente.tipo_paciente) {
            case "1": tipo_paciente.textContent = "Natural"; break;
            case "2": tipo_paciente.textContent = "Representante"; break;
            case "3": tipo_paciente.textContent = "Asegurado"; break;
            case "4": tipo_paciente.textContent = "Beneficiado"; break;
            default: tipo_paciente.textContent = "Desconocido"; break;
        }


        // ** Validamos si el paciente es asegurado y tiene seguros
        if (infoPaciente.tipo_paciente === "3" && infoPaciente.seguro.length > 0) {

            infoPaciente.seguro.forEach(el => {

                let nombreEmpresa = templateSeguro.getElementById("nombre_empresa");
                let nombreSeguro = templateSeguro.getElementById("nombre_seguro");

                let delLink = templateSeguro.querySelector(".del-seguroRelacion");
                let delIcon = templateSeguro.querySelector(".fa-trash");

                if (rol === "1" || rol === "2") {

                    delLink.setAttribute("onclick", `deleteSeguroRelacion(${el.paciente_seguro_id})`);
                } else {
                    delLink.setAttribute("data-bs-toggle", "")
                    delIcon.classList.add("d-none");
                }

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

        } else {

            if(infoPaciente.tipo_paciente === "3"){

                const seguroContainer = document.querySelector(".seguro-container");
                const seguroLabel = document.getElementById("seguroLabel");

                seguroLabel.classList.remove("d-none");

                seguroContainer.innerHTML = `<div class="help-message d-flex align-items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-secondary me-3"></i>
                    <h6 class="m-0">El paciente no posee un seguro asignado</h6>
                </div>`;


            } else {

                // Ocultamos el container
                const seguroContainer = document.getElementById("seguroContainer");
                seguroContainer.classList.add("d-none");
                seguroContainer.classList.add("invisible");
            }
            
        }

        // ** Validamos si el paciente es beneficiado y tiene titulares
        if (infoPaciente.tipo_paciente === "4" && infoPaciente?.titulares?.length > 0) {

            const tipo_familiar = {
                "1": "Padre/Madre",
                "2": "Representante",
                "3": "Primo/a",
                "4": "Hermano/a",
                "5": "Esposo/a",
                "6": "Tío/a",
                "7": "Sobrino/a",
            }

            infoPaciente.titulares.forEach(el => {

                let nombre = templateTitular.getElementById("nombre");
                let cedula = templateTitular.getElementById("cedula");
                let edad = templateTitular.getElementById("edad");
                let relacion = templateTitular.getElementById("relacion");
                let tipoDeRelacion = templateTitular.getElementById("tipo_relacion");

                let delLink = templateTitular.querySelector(".del-titularRelacion");
                let delIcon = templateTitular.querySelector(".fa-trash");

                if (rol === "1" || rol === "2") {

                    delLink.setAttribute("onclick", `deleteTitularRelacion(${el.titular_beneficiado_id})`);
                } else {
                    delLink.setAttribute("data-bs-toggle", "")
                    delIcon.classList.add("d-none");
                }

                nombre.textContent = `${el.nombre} ${el.apellidos}`;
                nombre.href = `../historialmedico/${el.paciente_id}`;
                cedula.textContent = el.cedula;
                edad.textContent = el.edad;
                relacion.textContent = tipo_familiar[el.tipo_familiar];
                tipoDeRelacion.textContent = el.tipo_relacion == 1 ? "Asegurada" : "Natural";

                let clone = document.importNode(templateTitular, true);
                titularFragment.appendChild(clone);
            });


            //Mostrarmos el label
            const titularLabel = document.getElementById("titularesLabel");
            titularLabel.classList.remove("d-none");

            // Actualizamos el contenedor e insertamos los datos
            titularContainer.replaceChildren();
            titularContainer.appendChild(titularFragment);
        } else {

            // Ocultamos el container
            const titularContainer = document.getElementById("titularesContainer");
            titularContainer.classList.add("d-none");
            titularContainer.classList.add("invisible");
        }

        // ** Validamos si el paciente es asegurado y tiene beneficiado
        if (infoPaciente.tipo_paciente === "3" && infoPaciente?.beneficiados?.length > 0) {

            const tipo_familiar = {
                "1": "Padre/Madre",
                "2": "Representante",
                "3": "Primo/a",
                "4": "Hermano/a",
                "5": "Esposo/a",
                "6": "Tío/a",
                "7": "Sobrino/a",
            }

            infoPaciente.beneficiados.forEach(el => {

                let nombre = templateBeneficiado.getElementById("nombre");
                let cedula = templateBeneficiado.getElementById("cedula");
                let edad = templateBeneficiado.getElementById("edad");
                let relacion = templateBeneficiado.getElementById("relacion");

                let delLink = templateBeneficiado.querySelector(".del-beneficiadoRelacion");
                let delIcon = templateBeneficiado.querySelector(".fa-trash");

                if (rol === "1" || rol === "2") {

                    delLink.setAttribute("onclick", `deleteBeneficiadoRelacion(${el.paciente_beneficiado_id})`);
                } else {
                    delLink.setAttribute("data-bs-toggle", "")
                    delIcon.classList.add("d-none");
                }

                nombre.textContent = `${el.nombre} ${el.apellidos}`;
                nombre.href = `../historialmedico/${el.paciente_id}`;
                cedula.textContent = el.cedula;
                edad.textContent = el.edad;
                relacion.textContent = tipo_familiar[el.tipo_familiar];

                let clone = document.importNode(templateBeneficiado, true);
                beneficiadoFragment.appendChild(clone);
            });

            //Mostrarmos el label
            const beneficiadoLabel = document.getElementById("beneficiadosLabel");
            beneficiadoLabel.classList.remove("d-none");
            beneficiadoContainer.classList.remove("d-none");
            beneficiadoContainer.classList.remove("invisible");

            // Actualizamos el contenedor e insertamos los datos
            beneficiadoContainer.replaceChildren();
            beneficiadoContainer.appendChild(beneficiadoFragment);

        } else {

            // Ocultamos el container
            const beneficiadoContainer = document.getElementById("beneficiadosContainer");
            beneficiadoContainer.classList.add("d-none");
            beneficiadoContainer.classList.add("invisible");
        }

        // ** Validamos en caso de que el paciente tenga citas pendientes
        if (listCita[0]?.cita_id) {

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

            cita_id.textContent = listCita[0].cita_id;
            nombre_medico.textContent = `${listCita[0].nombre_medico} ${listCita[0].apellido_medico}`;
            especialidad.textContent = listCita[0].nombre_especialidad;
            fecha_cita.textContent = formatToRealDate(listCita[0].fecha_cita);
            motivo_cita.textContent = listCita[0].motivo_cita;
            hora_entrada.textContent = listCita[0].hora_entrada;
            hora_salida.textContent = listCita[0].hora_salida;
            tipo_cita.textContent = listCita[0].tipo_cita === "2" ? "Asegurada" : "Natural";
            estatus_cit.textContent = listCita[0].estatus_cit === "3" ? "Pendiente" : "Asignada";


            dropdownLink.innerHTML = `<b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_cita.textContent}`;
            dropdownLink.setAttribute("data-bs-target", `#cita-${listCita[0].cita_id}`);
            dropdownLink.setAttribute("aria-controls", `#cita-${listCita[0].cita_id}`);
            citaContainer.setAttribute("id", `cita-${listCita[0].cita_id}`);

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
            const consultasLength = listConsultas.length - 1;

            let i = 0;
            for (const consulta of listConsultas) {
                
                let el = await getById("consultas", consulta.consulta_id);
                el = el[0];

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

                if(el.peso !== null) {
                    document.getElementById("pesoPaciente").textContent = `${el.peso} kg`;
                    $(".peso-text").fadeIn("slow");
                } 

                if(el.altura !== null) {
                    document.getElementById("alturaPaciente").textContent = `${el.altura} m`;
                    $(".altura-text").fadeIn("slow");
                } 
                // el.altura !== null ? document.getElementById("alturaPaciente").value = el.altura : undefined;
                // const peso = document.getElementById("pesoPaciente");
                // const altura = document.getElementById("alturaPaciente");

                let medicoNombre;
                let medicoApellido;
                let medicoEspecialidad;

                if (el?.medico && el?.medico.length > 0) {
                    medicoNombre = el.medico[0].nombre_medico;
                    medicoApellido = el.medico[0].apellidos_medico;
                    medicoEspecialidad = el.medico[0].nombre_especialidad;
                }

                consulta_id.textContent = el.consulta_id;
                nombre_medico.textContent = `${el.nombre_medico ?? medicoNombre ?? ""} ${el.apellidos_medico ?? medicoApellido ?? "Consulta por emergencia"}`;
                especialidad.textContent = el.nombre_especialidad ?? medicoEspecialidad ?? "Consulta por emergencia";
                fecha_consulta.textContent = formatToRealDate(el.fecha_consulta);
                observaciones.textContent = el.observaciones || "Sin observaciones";
                motivo_cita.textContent = el.es_emergencia == true ? "La consulta es de emergencia" : el.motivo_cita ?? `No aplica`;
                indicaciones.textContent = el.indicaciones !== undefined ? concatItems(el.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";

                dropdownLink.innerHTML = `<b>Especialidad:</b> ${especialidad.textContent} <br> <b>Fecha:</b> ${fecha_consulta.textContent}`;
                dropdownLink.setAttribute("data-bs-target", `#consulta-${el.consulta_id}`);
                dropdownLink.setAttribute("aria-controls", `#consulta-${el.consulta_id}`);
                consultaContainer.setAttribute("id", `consulta-${el.consulta_id}`);

                let clone = document.importNode(templateConsulta, true);
                consultaFragment.appendChild(clone);

            }

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
