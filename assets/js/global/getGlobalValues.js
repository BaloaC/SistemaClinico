import convertCurrencyToVES from "./convertCurrencyToVES.js";
import getAll from "./getAll.js";
import { confirmUpdateCurrencyExchange } from "./updateCurrencyExchange.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

export default async function getGlobalValues() {

	const globalValues = await getAll("globals");

	const currencyExchange = document.getElementById("currencyExchange");
	const medicPercentage = document.getElementById("medicPercentage");

	if (currencyExchange !== null) {

		fetch("https://pydolarvenezuela-api.vercel.app/api/v1/dollar?page=bcv")
			.then(response => {
				if (response.status !== 200) {
					throw response;
				}
				return response.json();
			})
			.then(json => {

				// Obtener enteros de price
				// const priceIntegers = Math.trunc(json.monitors.bcv.price).toString();  

				// Converter price_old usando los mismos números
				// const priceOld = `${priceIntegers}.${json.monitors.bcv.price_old.toString().slice(-6)}`;

				currencyExchange.innerText = `${convertCurrencyToVES(json.monitors.usd.price_old.toFixed(2))} Bs`;

				return globalValues[1]["value"];
			})
			.then(valorBack => confirmUpdateCurrencyExchange(valorBack, false))
			.catch(() => {
				currencyExchange.innerText = `${convertCurrencyToVES(parseFloat(globalValues[1]["value"]).toFixed(2))} Bs`;
			})
	}

	if (medicPercentage !== null) {
		medicPercentage.innerText = `${globalValues[0]["value"]}%`;
	}
}

document.addEventListener("DOMContentLoaded", async () => await getGlobalValues());