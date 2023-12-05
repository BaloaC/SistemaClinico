const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import { defaultSelect } from "./defaultSelect.js";
import scrollTo from "./scrollTo.js";
import select2DefaultValue from "./select2DefaultValue.js";

export default async function addModule(module, form, data, successMessage, modal = "#modalReg", alert = ".alert") {

    const $form = document.getElementById(form),
        $alert = document.querySelector(alert),
        modalActContent = document.querySelector(modal);

    try {

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify(data),
        };

        const response = await fetch(`/${path[1]}/${module}`, options),
            json = await response.json();

        if (response.status != 201 && response.status != 200) throw { result: json }

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = successMessage;
        $form.reset();
        defaultSelect();
        select2DefaultValue();

        scrollTo("modalRegBody");

        setTimeout(() => {
            $(modal).modal("hide");
            $alert.classList.add("d-none");
        }, 500);

        return json;

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;

        scrollTo("modalRegBody");

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 1500)

        return error;
    }

}