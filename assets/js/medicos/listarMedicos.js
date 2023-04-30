const d = document,
    path = location.pathname.split('/');

export default async function listarMedicos() {
    try {

        const response = await fetch(`/${path[1]}/medicos/consulta`),

            json = await response.json();

        if (!json.code) throw { result: json };

        console.log(json);

        return json.data;

    } catch (error) {

        alert(error);
    }
}

export async function listarMedicosPorId(id) {
    try {
        const response = await fetch(`/${path[1]}/medicos/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}