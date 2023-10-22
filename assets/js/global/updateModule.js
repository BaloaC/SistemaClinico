import deleteSecondValue from "./deleteSecondValue.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import scrollTo from "./scrollTo.js";

const path = location.pathname.split('/');

export default async function updateModule(data, data_id, module, form, successMessage) {

    const $form = document.getElementById(form);
    const $alert = document.getElementById("actAlert");
    
    try {

        const options = {

            method: "PUT",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify(data),
        };

        const response = await fetch(`/${path[1]}/${module}/${data[data_id]}`, options),
            json = await response.json();

        if (!json.code) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = successMessage;
        $form.reset();

        scrollTo("modalActBody");

        setTimeout(() => {
            $("#modalAct").modal("hide");
            $alert.classList.add("d-none");
        }, 500);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        scrollTo("modalActBody");

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }

    //#btn - actualizarInfo"
}