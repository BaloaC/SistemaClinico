import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import truncateToTwoDecimals from "../global/truncateToTwoDecimals.js";

export async function calcularPreciosAnteriores(input) {

    const divElement = input.parentElement.parentElement.querySelectorAll("td")[5].querySelector("div");
    const mantenerPrecioRadioInput = divElement.querySelector("#antiguoPrecio");
    const precioAnteriorLabel = divElement.querySelector("#precioAnteriorLabel");
    const nuevoPrecioRadioInput = divElement.querySelector("#nuevoPrecio");
    const precioNuevoLabel = divElement.querySelector("#precioNuevoLabel");
    $(".actualizarPrecio-insumo").fadeIn("slow");


    mantenerPrecioRadioInput.checked = true;
    mantenerPrecioRadioInput.style = "display:inline !important";
    nuevoPrecioRadioInput.style = "display:inline !important";
    precioNuevoLabel.style = "display:inline !important";


    if (!input.value) {
        precioAnteriorLabel.innerText = `El insumo no es cobrado`;
        precioNuevoLabel.innerText = `El insumo no es cobrado`;
        mantenerPrecioRadioInput.checked = true;
        mantenerPrecioRadioInput.style = "display:none";
        nuevoPrecioRadioInput.style = "display:none";
        precioNuevoLabel.style = "display:none";

    }
    const insumo = await getById("insumos", input.value);
    const porcentajeGlobal = await getAll("globals");
    let porcentajePrecioNuevo = (parseFloat(insumo.precio) + (parseFloat(porcentajeGlobal[2].value) / 100));
    porcentajePrecioNuevo = porcentajePrecioNuevo / insumo.capacidad_unidad;

    if (insumo.precio === 0) {

        precioAnteriorLabel.innerText = "El insumo no es cobrado";
        precioNuevoLabel.innerText = "El insumo no es cobrado";
        mantenerPrecioRadioInput.checked = true;
        nuevoPrecioRadioInput.style = "display:none !important";
        precioNuevoLabel.style = "display:none !important";
        mantenerPrecioRadioInput.style = "display:none";

    } else {
        precioAnteriorLabel.innerText = `Mantener precio anterior ($${Math.round(insumo.precio * 100) / 100})`;

        precioNuevoLabel.innerText = `Actualizar nuevo precio ($${(Math.round(porcentajePrecioNuevo * 100) / 100)})`;
    }
}

window.calcularPreciosAnteriores = calcularPreciosAnteriores;