import convertCurrencyToVES from "./convertCurrencyToVES.js";
import getAll from "./getAll.js";

export default async function getGlobalValues() {

    const globalValues = await getAll("globals");

    const currencyExchange = document.getElementById("currencyExchange");
    const medicPercentage = document.getElementById("medicPercentage");

    if(currencyExchange !== null) {
        currencyExchange.innerText = `${convertCurrencyToVES(globalValues[1]["value"])} Bs`;
    }

    if(medicPercentage !== null) {
        medicPercentage.innerText = `${globalValues[0]["value"]}%`;
    }
}

document.addEventListener("DOMContentLoaded", async () => await getGlobalValues());