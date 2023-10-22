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

        const cedula = document.getElementById("cedula_medico");
        const nombre = document.getElementById("nombre_medico");
        const telefono = document.getElementById("telefono");
        const direccion = document.getElementById("direccion");
        const acumulado = document.getElementById("acumulado");
        const citaContainer = document.getElementById("citaAccordion");
        const templateCita = document.getElementById("template-cita").content;
        const especialidadMedico = document.getElementById("especialidadMedico");
        const horarioMedico = document.querySelector("#horarios-table tbody");
        const citaFragment = document.createDocumentFragment();

        const infoMedico = await getById("medicos", id);
        const listCitas = await getById("citas/medico", id);

        cedula.textContent = infoMedico[0].cedula;
        nombre.textContent = `${infoMedico[0].nombre} ${infoMedico[0].apellidos}`;
        telefono.textContent = infoMedico[0].telefono;
        direccion.textContent = infoMedico[0].direccion;
        acumulado.textContent = infoMedico[0].acumulado;

        let horario = "";
        let especialidad = "";

        if (infoMedico[0].horario?.length >= 1) {

            $("#horarioMessage").fadeOut("slow");
            $("#horarios-table").fadeIn("slow");

            infoMedico[0].horario.forEach(el => {
                horario += `
                    <tr>
                        <td>${el.dias_semana}</td>
                        <td>${el.hora_entrada}</td>
                        <td>${el.hora_salida}</td>
                        <td>
                            <button class="btn btn-sm btn-empresa" id="btn-add" value="asdas${el.horario_id}" ${infoMedico[0].horario.length >= 1
                        ? `onclick=(deleteHorario(${el.horario_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                        : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                                <i class="fa-sm fas fa-times"></i> 
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            $("#horarioMessage").fadeIn("slow");
            $("#horarios-table").fadeOut("slow");
        }

        horarioMedico.innerHTML = horario;


        if (infoMedico[0].especialidad?.length >= 1) {

            infoMedico[0].especialidad.forEach(el => {
                especialidad += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.medico_especialidad_id}" ${infoMedico[0].especialidad.length > 1
                        ? `onclick=(deleteEspecialidad(${el.medico_especialidad_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                        : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    ${el.nombre_especialidad}
                    <i class="fa-sm fas fa-times"></i> 
                </button>
            `;
            });

            especialidadMedico.innerHTML = especialidad;

        } else {

            especialidadMedico.innerHTML = "Este médico no posee ninguna especialidad";
        }
    

        // ** Validamos en caso de que el paciente tenga citas pendientes
        if (listCitas?.length > 0) {

            const citasLabel = document.getElementById("citasLabel");
            citasLabel.classList.remove("d-none");

            // !! En caso de que se necesite mostrar más citas
            listCitas.forEach((cita, i) => {

                let dropdownLink = templateCita.querySelector(".btn-link");
                let citaContainer = templateCita.querySelector(".collapse");
                let cita_id = templateCita.getElementById("cita_id");
                let nombre_paciente = templateCita.getElementById("nombre_paciente");
                let especialidad = templateCita.getElementById("especialidad");
                let fecha_cita = templateCita.getElementById("fecha_cita");
                let motivo_cita = templateCita.getElementById("motivo_cita");
                let hora_entrada = templateCita.getElementById("hora_entrada");
                let hora_salida = templateCita.getElementById("hora_salida");
                let tipo_cita = templateCita.getElementById("tipo_cita");
                let estatus_cit = templateCita.getElementById("estatus_cit");

                // ! En caso de que se necesite mostrar más citas
                if (i === 0) {
                    citaContainer.classList.add("show");
                } else {
                    citaContainer.classList.remove("show");
                }

                cita_id.textContent = cita.cita_id;
                nombre_paciente.textContent = `${cita.nombre_paciente} ${cita.apellido_paciente}`;
                especialidad.textContent = cita.nombre_especialidad;
                fecha_cita.textContent = cita.fecha_cita;
                motivo_cita.textContent = cita.motivo_cita;
                hora_entrada.textContent = cita.hora_entrada;
                hora_salida.textContent = cita.hora_salida;
                tipo_cita.textContent = cita.tipo_cita === "2" ? "Asegurada" : "Natural";
                estatus_cit.textContent = cita.estatus_cit === "3" ? "Pendiente" : "Asignada";
                

                dropdownLink.innerHTML = `<b>ID:</b> ${cita_id.textContent} - <b>Nombre médico:</b> ${nombre_medico.textContent} - <b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_cita.textContent}`;
                dropdownLink.setAttribute("data-bs-target", `#cita-${cita.cita_id}`);
                dropdownLink.setAttribute("aria-controls", `#cita-${cita.cita_id}`);
                citaContainer.setAttribute("id", `cita-${cita.cita_id}`);

                let clone = document.importNode(templateCita, true);
                citaFragment.appendChild(clone);
            });

            // Actualizamos el contenedor e insertamos los datos
            citaContainer.replaceChildren();
            citaContainer.appendChild(citaFragment);

        } else {
            const h4 = document.createElement("h4");
            h4.classList.add("mt-3");
            h4.textContent = "El médico no posee citas pendientes";

            // Actualizamos el contenedor e insertamos los datos
            citaContainer.replaceChildren();
            citaContainer.appendChild(h4);
        }

    } catch (error) {
        console.log(error);
    }
}

window.mostrarPerfilMedico = mostrarPerfilMedico;

document.addEventListener("DOMContentLoaded", async () => {

    const urlParams = new URLSearchParams(window.location.search);
    const medico_id = urlParams.get('medico');

    const actMedico = document.querySelector(".act-medico");
    actMedico.setAttribute("onclick", `updateMedico(${medico_id})`);

    await mostrarPerfilMedico(medico_id);
})
