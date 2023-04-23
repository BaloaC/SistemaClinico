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

    monto.textContent = `$${montoTotalProducto.toFixed(2)}`;
    monto.dataset.iva = iva;
    monto.dataset.montoSinIva = montoTotalProductoSinIva;

    let [montoTotalFactura, totalIvaFactura, montoTotalFacturaSinIva, totalUnidades] = [0, 0, 0, 0];
    const allMontos = document.querySelectorAll(".monto-total-p"),
        allUnidades = document.querySelectorAll(".insumo-unid");

    allMontos.forEach((value, key) => {
        montoTotalFactura += parseFloat(value.textContent.slice(1));
        totalIvaFactura += parseFloat(value.dataset.iva);
        montoTotalFacturaSinIva += parseFloat(value.dataset.montoSinIva);
        totalUnidades += parseInt(allUnidades[key].value);
    })

    console.log(totalUnidades);

    if (montoTotalFactura === NaN || totalIvaFactura === NaN || montoTotalFacturaSinIva === NaN || totalUnidades === NaN) return;
    montoSinIva.textContent = `$${montoTotalFacturaSinIva.toFixed(2)}`;
    productosTotales.textContent = `${totalUnidades}`;
    totalIva.textContent = `$${totalIvaFactura.toFixed(2)}`;
    total.textContent = `$${montoTotalFactura.toFixed(2)}`;

}

window.calcularMonto = calcularMonto;