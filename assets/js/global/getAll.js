const path = location.pathname.split('/');

export default async function getAll(module) {
    try {
        const response = await fetch(`/${path[1]}/${module}`),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {

        console.log(error);
    }
}
