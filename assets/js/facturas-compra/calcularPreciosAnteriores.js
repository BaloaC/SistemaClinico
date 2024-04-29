import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

async function calcularPreciosAnteriores(input){

    const divElement = input.parentElement.parentElement.querySelectorAll("td")[5].querySelector("div");
    const precioAnteriorLabel = divElement.querySelector("#precioAnteriorLabel");
    const precioNuevoLabel = divElement.querySelector("#precioNuevoLabel");

    if(!input.value){
        precioAnteriorLabel.innerText = `Mantener precio anterior ($0.00)`;
        precioNuevoLabel.innerText = `Actualizar nuevo precio ($0.00)`;
    }

    const insumo = await getById("insumos", input.value);
    const porcentajeGlobal = await getAll("globals");

  

    precioAnteriorLabel.innerText = `Mantener precio anterior ($${insumo.precio.toFixed(2)})`;

    let porcentajePrecioNuevo = (parseFloat(insumo.precio) * (parseFloat(porcentajeGlobal[2].value) / 100));

    precioNuevoLabel.innerText = `Actualizar nuevo precio ($${(parseFloat(insumo.precio) + parseFloat(porcentajePrecioNuevo)).toFixed(2)})`;
}

window.calcularPreciosAnteriores = calcularPreciosAnteriores;