const d = document,
    path = location.pathname.split('/');

export async function listarHorariosPorId(id) {
    try {
        const response = await fetch(`/${path[1]}/pacientes/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}