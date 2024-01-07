import { clicks } from "./addInsumoInput.js";

let clicksCalculate = 0;
function calcularMonto(input) {

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

    // // let test = document.querySelector('.insumo-unid');
    // precioUnitario.addEventListener('keydown', function (event) {
    //     if (event.key === '-' || event.code === 'Slash') {
    //         event.preventDefault();
    //     }

    // });

    let [montoTotalProducto, iva, montoTotalProductoSinIva] = [0, 0, 0];

    if (insumo === "" || precioUnitario === "" || unidades === "") return;

    montoTotalProducto = parseFloat(precioUnitario) * parseFloat(unidades);
    montoTotalProductoSinIva = montoTotalProducto;

    if (impuesto) {
        iva = montoTotalProducto * 0.16;
        montoTotalProducto += iva;
    }

    monto.textContent = (montoTotalProducto == NaN) ? "$0.00" : `$${montoTotalProducto.toFixed(2)}`;
    monto.dataset.iva = iva;
    monto.dataset.montoSinIva = montoTotalProductoSinIva;

    let [montoTotalFactura, totalIvaFactura, montoTotalFacturaSinIva, totalUnidades] = [0, 0, 0, 0];
    const allMontos = document.querySelectorAll(".monto-total-p"),
        allUnidades = document.querySelectorAll(".insumo-unid");

    allMontos.forEach((value, key) => {
        montoTotalFactura += (value.textContent.slice(1)) ? parseFloat(value.textContent.slice(1)) : 0;
        totalIvaFactura += (value.dataset.iva !== undefined) ? parseFloat(value.dataset.iva) : 0;
        montoTotalFacturaSinIva += (value.dataset.montoSinIva !== undefined) ? parseFloat(value.dataset.montoSinIva) : 0;
        totalUnidades += (allUnidades[key].value !== "") ? parseInt(allUnidades[key].value) : 0;
    })

    if (montoTotalFactura == NaN || totalIvaFactura == NaN || montoTotalFacturaSinIva == NaN || totalUnidades == NaN) return;

    montoSinIva.textContent = (montoTotalFacturaSinIva == NaN) ? "$0.00" : `$${montoTotalFacturaSinIva.toFixed(2)}`;
    productosTotales.textContent = (totalUnidades == NaN) ? "0" : `${totalUnidades}`;
    totalIva.textContent = (totalIvaFactura == NaN) ? "$0.00" : `$${totalIvaFactura.toFixed(2)}`;
    total.textContent = (montoTotalFactura == NaN) ? "$0.00" : `$${montoTotalFactura.toFixed(2)}`  ;

}

window.calcularMonto = calcularMonto;