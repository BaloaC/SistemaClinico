const d = document,
    path = location.pathname.split('/');

export default async function listarSeguros() {
    try {

        const response = await fetch(`/${path[1]}/seguros/consulta`),

            json = await response.json();

        if (!json.code) throw { result: json };
        // TODO: añadir validación de cuando no exista ningún seguro 

        return json.data;

    } catch (error) {

        alert(error);
    }
}

export async function listarSegurosPorId(id) {
    try {
        const response = await fetch(`/${path[1]}/seguros/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}