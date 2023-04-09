import Cookies from "../../libs/jscookie/js.cookie.min.js";
const path = location.pathname.split('/');

export default async function getById(module,id) {
    try {

        const options = {
            method: "GET",
            headers: {
                
                "Authorization": "Bearer " + Cookies.get("tokken")
            }
        };

        const response = await fetch(`/${path[1]}/${module}/${id}`,options),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        return error;
    }
}