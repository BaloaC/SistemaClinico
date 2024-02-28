import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import { patterns } from "../global/patternsValidation.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import scrollTo from "./scrollTo.js";
import getGlobalValues from "./getGlobalValues.js";

const d = document,
    path = location.pathname.split('/');


async function updateCurrencyExchange() {

    try {

        const currentPrice = document.getElementById("currencyExchange").textContent.split(" ")[0];
        document.getElementById("cambioDivisaInput").value = currentPrice;

    } catch (error) {

        console.log(error);
    }
}

window.updateCurrencyExchange = updateCurrencyExchange;

async function confirmUpdateCurrencyExchange() {
    const form = document.getElementById("act-cambioDivisa"),
        alert = document.getElementById("actAlert");

    try {
        const formData = new FormData(form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!form.checkValidity()) { form.reportValidity(); return; }
        if (!(patterns.price.test(data.cambio_divisa))) throw { message: "El valor debe ser númerico y sin números negativos" };

        const parseData = deleteSecondValue("#act-cambioDivisa input, #act-cambioDivisa select", data);

        const options = {

            method: "PUT",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify({ cambio_divisa: parseData.cambio_divisa })
        };

        const currentPrice = document.getElementById("currencyExchange").textContent.split(" ")[0];

        // Validamos que si el precio es igual, no hacer la petición
        if (currentPrice != parseData.cambio_divisa){
        
            let response = await fetch(`/${path[1]}/cambioDivisa`, options)
            const json = await response.json();
    
            if (!json.code) throw { result: json };
        }


        alert.classList.remove("alert-danger");
        alert.classList.add("alert-success");
        alert.classList.remove("d-none");
        alert.textContent = "Monto actualizado correctamente!";
        form.reset();
        scrollTo("modalActBody");

        setTimeout(() => {
            $("#modalAct").modal("hide");
            alert.classList.add("d-none");
        }, 750);

        cleanValdiation("act-cambioDivisa");
        await getGlobalValues();
        $('#especialidades').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        alert.textContent = message;

        setTimeout(() => {
            alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdateCurrencyExchange = confirmUpdateCurrencyExchange;
document.getElementById("act-cambioDivisa").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdateCurrencyExchange();
})