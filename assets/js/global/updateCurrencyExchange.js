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
        document.getElementById("cambioDivisaInput").value = currentPrice.replace(",",".");

    } catch (error) {

        console.log(error);
    }
}

window.updateCurrencyExchange = updateCurrencyExchange;

export async function confirmUpdateCurrencyExchange(cambioDivisa) {

    try {
        const currentPrice = document.getElementById("currencyExchange").textContent.split(" ")[0];
        
        const options = {

            method: "PUT",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify({ cambio_divisa: currentPrice.toString().replace(",",".") })
        };

        // Validamos que si el precio es igual, no hacer la petición
        if (currentPrice.toString().replace(",",".") != cambioDivisa){
        
            let response = await fetch(`/${path[1]}/cambioDivisa`, options)
            const json = await response.json();
    
            if (!json.code) throw { result: json };
        }

    } catch (error) {
        console.log(error);
    }
}

window.confirmUpdateCurrencyExchange = confirmUpdateCurrencyExchange;
document.getElementById("act-cambioDivisa").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdateCurrencyExchange();
})

document.addEventListener("DOMContentLoaded", () => {
    if (Cookies.get("rol") == 4 || Cookies.get("rol") == 5) {
        document.getElementById("currencyExchangeNavLink").removeAttribute("data-bs-target");
        document.getElementById("currencyExchangeNavLink").classList.remove("cursor-pointer");
    }
})