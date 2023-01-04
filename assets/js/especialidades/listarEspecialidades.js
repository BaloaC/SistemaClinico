const d = document,
    path = location.pathname.split('/');


export default async function listarEspecialidades() {
    try {
        const response = await fetch(`/${path[1]}/especialidades/consulta`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}

export async function listarEspecialidadesPorId(id) {
    try {
        const response = await fetch(`/${path[1]}/especialidades/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}