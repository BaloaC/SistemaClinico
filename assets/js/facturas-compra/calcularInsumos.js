import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import truncateToTwoDecimals from "../global/truncateToTwoDecimals.js";

async function calcularMonto(input) {

    const insumoContainer = input.parentElement.parentElement;
    let unidades = insumoContainer.querySelector("input[name='unidades']").value,
        precioUnitario = insumoContainer.querySelector("input[name='precio_unit']").value,
        impuesto = insumoContainer.querySelector("input[type='checkbox']").checked,
        insumo = insumoContainer.querySelector("select").value,
        monto = insumoContainer.querySelector("td > b"),
        montoSinIva = document.getElementById("monto-sin-iva"),
        totalIva = document.getElementById("iva"),
        productosTotales = document.getElementById("productos-totales"),
        total = document.getElementById("monto-total");

    let [montoTotalProducto, iva, montoTotalProductoSinIva] = [0, 0, 0];

    if (insumo === "" || precioUnitario === "") return;

    // Lógica para actualizar los precios de los insumos
    const precioNuevoLabel = insumoContainer.querySelector("#precioNuevoLabel");
    const precioNuevoRadioInput = insumoContainer.querySelector("#nuevoPrecio");
    const precioAntiguoLabel = insumoContainer.querySelector("#precioAnteriorLabel");
    const precioAnteriorRadioInput = insumoContainer.querySelector("#antiguoPrecio");
    const porcentajeGlobal = await getAll("globals");
    
    let precioUnitarioEnDolares = parseFloat(precioUnitario) / parseFloat(porcentajeGlobal[1].value);
    let precioOriginalUnitario = precioUnitarioEnDolares;
    let porcentajePrecioUnitario = parseFloat((precioUnitarioEnDolares * porcentajeGlobal[2].value) / 100);
    precioUnitarioEnDolares = Math.round((precioOriginalUnitario + porcentajePrecioUnitario) * 100) / 100;
    
    // calculo del precio total
    precioNuevoLabel.innerText = `Actualizar nuevo precio ($${( (precioUnitarioEnDolares) )})`;
    precioNuevoRadioInput.style = "display: inline !important";
    precioAntiguoLabel.style = "display: inline !important";
    precioAnteriorRadioInput.style = "display: inline !important";
    
    if(impuesto) {
        // Actualizar el precio en dolares si se selecciona el impuesto
        let ivaPreciUnitarioEnDolares = precioUnitarioEnDolares * 0.16;
        precioUnitarioEnDolares += ivaPreciUnitarioEnDolares;
        precioNuevoLabel.innerText = `Actualizar nuevo precio ($${ Math.round(precioUnitarioEnDolares * 100) / 100 })`;
    }

    if(truncateToTwoDecimals(precioUnitarioEnDolares) === "0.00") {
        precioNuevoLabel.innerText = "El precio debe ser mayor a 0 para actualizarlo";
        precioNuevoRadioInput.style = "display: none !important";
        precioAntiguoLabel.style = "display: none !important";
        precioAnteriorRadioInput.style = "display: none !important";
        precioAnteriorRadioInput.checked = true;
    }

    // Validamos que se envie las unidades para poder actualizar todos los montos
    if(unidades === "") return;

    montoTotalProducto = parseFloat(precioUnitario) * parseFloat(unidades);
    montoTotalProductoSinIva = montoTotalProducto;

    if (impuesto) {
        iva = montoTotalProducto * 0.16;
        montoTotalProducto += iva;
    }

    monto.textContent = (montoTotalProducto == NaN) ? "0.00 Bs" : `${ Math.round( (montoTotalProducto) * 100 ) / 100} Bs`;
    monto.dataset.iva = iva;
    monto.dataset.montoSinIva = montoTotalProductoSinIva;

    let [montoTotalFactura, totalIvaFactura, montoTotalFacturaSinIva, totalUnidades] = [0, 0, 0, 0];
    const allMontos = document.querySelectorAll(".monto-total-p"),
        allUnidades = document.querySelectorAll(".insumo-unid");

    allMontos.forEach((value, key) => {
        montoTotalFactura += (value.textContent.substring(0, value.textContent.length - 3)) ? parseFloat(value.textContent.substring(0, value.textContent.length - 3)) : 0;
        totalIvaFactura += (value.dataset.iva !== undefined) ? parseFloat(value.dataset.iva) : 0;
        montoTotalFacturaSinIva += (value.dataset.montoSinIva !== undefined) ? parseFloat(value.dataset.montoSinIva) : 0;
        totalUnidades += (allUnidades[key].value !== "") ? parseInt(allUnidades[key].value) : 0;
    })

    if (montoTotalFactura == NaN || totalIvaFactura == NaN || montoTotalFacturaSinIva == NaN || totalUnidades == NaN) return;

    montoSinIva.textContent = (montoTotalFacturaSinIva == NaN) ? "0.00 Bs" : `${ Math.round( (montoTotalFacturaSinIva) * 100 ) / 100} Bs`;
    productosTotales.textContent = (totalUnidades == NaN) ? "0" : `${totalUnidades}`;
    totalIva.textContent = (totalIvaFactura == NaN) ? "0.00 Bs" : `${ Math.round( (totalIvaFactura) * 100 ) / 100} Bs`;
    total.textContent = (montoTotalFactura == NaN) ? "0.00 Bs" : `${ Math.round( (montoTotalFactura) * 100 ) / 100} Bs`;

}

window.calcularMonto = calcularMonto;