const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";

export default async function getAll(module) {
    try {

        const options = {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + Cookies.get("tokken")
            }
        }

        const response = await fetch(`/${path[1]}/${module}`,options),
            json = await response.json();

        if (!json.code) throw { result: json };

        return json.data;
    } catch (error) {
        console.log(error);
    }
}
