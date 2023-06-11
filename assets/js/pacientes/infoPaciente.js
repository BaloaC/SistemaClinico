import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];

async function getPaciente(id) {
    try {

        const nombre = document.getElementById("nombre_paciente");
        const fecha = document.getElementById("fecha");
        const edad = document.getElementById("edad");
        const consultaPdf = document.getElementById("consulta-pdf");
        const antecedenteContainer = document.querySelector(".antecedente-container");
        const templateAntecedente = document.getElementById("template-antecedente").content;
        const antecedenteFragment = document.createDocumentFragment();
        const consultaContainer = document.getElementById("consultaAccordion");
        const templateConsulta = document.getElementById("template-consulta").content;
        const consultaFragment = document.createDocumentFragment();

        const infoPaciente = await getById("pacientes", id);
        const infoConsultas = await getById("consultas/paciente", id);
        console.log(infoConsultas);

        nombre.textContent = `${infoPaciente.nombre || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
        fecha.textContent = `${infoPaciente.fecha_nacimiento}`;
        edad.textContent = `${infoPaciente.edad}`;

        // ** Validamos si el paciente cuenta con antecedetes médicos
        if (infoConsultas.antecedentes_medicos.length > 0) {

            infoConsultas.antecedentes_medicos.forEach(el => {

                let tipoAntecedente = templateAntecedente.getElementById("tipo_antedecente");
                let descripcionAntecedente = templateAntecedente.getElementById("descripcion_antecedente");

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


        // ** Validación en caso de que el paciente tenga consultas registradas
        if (infoConsultas.consultas.length > 0) {

            consultaPdf.classList.remove("d-none");
            consultaPdf.setAttribute("onclick", `openPopup('pdf/historialmedico/${id}')`);

            let consultaTemplate = '';
            infoConsultas.consultas.forEach( (el,i) => {

                let dropdownLink = templateConsulta.querySelector(".btn-link");
                let consultaContainer = templateConsulta.querySelector(".collapse");
                let consulta_id = templateConsulta.getElementById("consulta_id");
                let nombre_medico = templateConsulta.getElementById("nombre_medico");
                let especialidad = templateConsulta.getElementById("especialidad");
                let fecha_consulta = templateConsulta.getElementById("fecha_consulta");
                let observaciones = templateConsulta.getElementById("observaciones");

                if(i === 0){
                    consultaContainer.classList.add("show");
                } else {
                    consultaContainer.classList.remove("show");
                }

                consulta_id.textContent = el.consulta_id;
                nombre_medico.textContent = `${el.nombre_medico} ${el.apellido_medico}`;
                especialidad.textContent = el.nombre_especialidad;
                fecha_consulta.textContent = el.fecha_consulta;
                observaciones.textContent = el.observaciones;

                dropdownLink.innerHTML = `<b>ID:</b> ${consulta_id.textContent} - <b>Nombre médico:</b> ${nombre_medico.textContent} - <b>Especialidad:</b> ${especialidad.textContent} - <b>Fecha:</b> ${fecha_consulta.textContent}`;
                dropdownLink.setAttribute("data-bs-target",`#consulta-${el.consulta_id}`);
                dropdownLink.setAttribute("aria-controls",`#consulta-${el.consulta_id}`);
                consultaContainer.setAttribute("id",`consulta-${el.consulta_id}`);

                let clone = document.importNode(templateConsulta, true);
                consultaFragment.appendChild(clone);
            });

            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(consultaFragment);

        } else {
            consultaPdf.classList.add("d-none");
            const h4 = document.createElement("h4");
            h4.textContent = "El paciente no posee consultas";
            
            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(h4);
        }
    } catch (error) {
        console.log(error);
    }
}

window.getPaciente = getPaciente;

document.addEventListener("DOMContentLoaded", async () => {
    await getPaciente(id);
})
