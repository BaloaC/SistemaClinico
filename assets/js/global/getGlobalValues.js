import convertCurrencyToVES from "./convertCurrencyToVES.js";
import getAll from "./getAll.js";
import { confirmUpdateCurrencyExchange } from "./updateCurrencyExchange.js";

export default async function getGlobalValues() {

    const globalValues = await getAll("globals");

    const currencyExchange = document.getElementById("currencyExchange");
    const medicPercentage = document.getElementById("medicPercentage");

    if(currencyExchange !== null) {

        fetch("https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv")
        .then(response => response.json())
        .then(json => {
            currencyExchange.innerText = `${convertCurrencyToVES(json.monitors.usd.price)} Bs`;

            return globalValues[1]["value"];
        })
        .then(valorBack => confirmUpdateCurrencyExchange(valorBack))
        .catch(error => console.log(error))
    }

    if(medicPercentage !== null) {
        medicPercentage.innerText = `${globalValues[0]["value"]}%`;
    }
}

document.addEventListener("DOMContentLoaded", async () => await getGlobalValues());