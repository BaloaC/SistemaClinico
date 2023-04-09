const path = location.pathname.split('/')
import Cookies from "../../libs/jscookie/js.cookie.min.js";


export default async function deleteModule(module, id, successMessage) {

    const $alert = document.getElementById("delAlert");

    try {
        const options = {

            method: "DELETE",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
        };

        const response = await fetch(`/${path[1]}/${module}/${id}`, options);

        let json = await response.json();

        if (response.status != 200) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = successMessage;

        setTimeout(() => {
            $("#modalDelete").modal("hide");
            $alert.classList.add("d-none");
        }, 500);

        return true;

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.result.message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)

        return false;
    }
}
