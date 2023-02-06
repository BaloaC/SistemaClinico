import getById from "../global/getById.js";

async function getPaciente(id) {
    try {

        const $nombre = document.getElementById("nombre_paciente"),
            $fecha = document.getElementById("fecha"),
            $edad = document.getElementById("edad");

        const infoPaciente = await getById("pacientes",id);

        console.log(infoPaciente);

        //TODO: Agregar los demás datos del paciente y su historial médico

        $nombre.textContent = `${infoPaciente.nombres || infoPaciente.nombre_paciente} ${infoPaciente.apellidos}`;
        $fecha.textContent = `${infoPaciente.fecha_nacimiento}`;
        $edad.textContent = `${infoPaciente.edad}`;

    } catch (error) {
        console.log(error);
    }
}

window.getPaciente = getPaciente;