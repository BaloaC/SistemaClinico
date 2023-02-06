const path = location.pathname.split('/');

export default async function getById(module,id) {
    try {
        const response = await fetch(`/${path[1]}/${module}/${id}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}