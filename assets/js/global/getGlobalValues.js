import convertCurrencyToVES from "./convertCurrencyToVES.js";
import getAll from "./getAll.js";

export default async function getGlobalValues() {

    const globalValues = await getAll("globals");

    const currencyExchange = document.getElementById("currencyExchange");
    const medicPercentage = document.getElementById("medicPercentage");

    if(currencyExchange !== null) {

        fetch("https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv")
        .then(response => response.json())
        .then(json => {
            currencyExchange.innerText = `${convertCurrencyToVES(json.monitors.usd.price)} Bs`;
        })
        .catch(error => console.log(error))
    }

    if(medicPercentage !== null) {
        medicPercentage.innerText = `${globalValues[0]["value"]}%`;
    }
}

document.addEventListener("DOMContentLoaded", async () => await getGlobalValues());