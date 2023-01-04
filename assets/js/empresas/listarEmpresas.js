const d = document,
    path = location.pathname.split('/');

export default async function listarEmpresas() {
    try {

        const response = await fetch(`/${path[1]}/empresas/consulta`),

            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;

    } catch (error) {

        alert(error);
    }
}

export async function listarEmpresaPorId(id) {
    try {
        const response = await fetch(`/${path[1]}/empresas/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}
