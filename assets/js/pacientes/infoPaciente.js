import { listarPacientePorId } from "./listarPacientes.js";

const d = document,
    path = location.pathname.split('/');

d.addEventListener("click", async e => {

    if(e.target.matches(".view-info")){

        try {
            
            const $nombre = d.getElementById("nombre_paciente"),
            $fecha = d.getElementById("fecha"),
            $edad = d.getElementById("edad");

            const infoPaciente = await listarPacientePorId(e.target.dataset.id);

            console.log(infoPaciente);

            //TODO: Agregar los demás datos del paciente y su historial médico

            $nombre.textContent =  `${infoPaciente.nombres || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
            $fecha.textContent =  `${infoPaciente.fecha_nacimiento}`;
            $edad.textContent = `${infoPaciente.edad}`;

        } catch (error) {
            
        }
    }



})