import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

async function getPaciente(id) {
    try {

        const $nombre = document.getElementById("nombre_paciente"),
            $fecha = document.getElementById("fecha"),
            $edad = document.getElementById("edad"),
            $observacion = document.getElementById("observacion"),
            $consultaPdf = document.getElementById("consulta-pdf"),
            $consultas = document.querySelector(".paciente-consulta > ul");

        const infoPaciente = await getById("pacientes", id);
        const infoConsultas = await getAll("consultas/consulta");
        const consultasPacientes = infoConsultas.filter(consulta => consulta.paciente_id === id);


        $nombre.textContent = `${infoPaciente.nombre || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
        $fecha.textContent = `${infoPaciente.fecha_nacimiento}`;
        $edad.textContent = `${infoPaciente.edad}`;

        // ** Validación en caso de que el paciente tenga consultas registradas
        if (consultasPacientes.length > 0) {

            $observacion.textContent = consultasPacientes[0].observaciones;
            $consultaPdf.classList.remove("d-none");
            $consultaPdf.setAttribute("onclick", `openPopup('pdf/historialmedico/${id}')`);

            let consultaTemplate = '';
            consultasPacientes.forEach(el => {
                consultaTemplate += `
                <li>
                    <p>Consulta ID: <span id="consulta_id">${el.consulta_id}</span> <br> Nombre médico: <span id="nombre_medico">${el.nombre_medico} ${el.apellido_medico}</span> <br> Especialidad: <span id="especilidad">${el.nombre_especialidad}</span> <br> Fecha consulta: <span id="fecha_consulta">${el.fecha_consulta}</span> <br> Observaciones: <span id="observaciones">${el.observaciones ?? 'Sin observaciones'}</span></p>
                </li>
                `
            });
            $consultas.innerHTML = consultaTemplate;

        } else {
            $consultaPdf.classList.add("d-none");
            $observacion.textContent = "Este paciente no posee consultas";
            $consultas.innerHTML = `
            <li>
                <p>Este paciente no posee consultas</p>
            </li>
            `;
        }
    } catch (error) {
        console.log(error);
    }
}

window.getPaciente = getPaciente;