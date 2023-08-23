import getAll from "../global/getAll.js";

export default async function getTitulares() {
    try {
        const pacientes = await getAll("pacientes/consulta"),
            titulares = [];
        pacientes.filter(paciente => (paciente.tipo_paciente == 2 || paciente.tipo_paciente == 3) ? titulares.push(paciente) : null);

        return titulares;
    } catch (error) {
        console.log(error);
    }
};
