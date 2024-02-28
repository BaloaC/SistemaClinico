import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById(`factura/compra`,id);

console.log(data);

document.getElementById("proveedor").textContent = data.proveedor_nombre;
document.getElementById("factura_id").textContent = data.factura_compra_id;
document.getElementById("monto_sin_iva").textContent = `${convertCurrencyToVES(data.monto_sin_iva)} Bs`;
document.getElementById("monto_con_iva").textContent = `${convertCurrencyToVES(data.monto_con_iva)} Bs`;
document.getElementById("monto_usd").textContent = `$${data.monto_usd}`;
document.getElementById("fecha_compra").textContent = data.fecha_compra.split(" ")[0];
document.getElementById("excento").textContent = `${convertCurrencyToVES(data.excento) ?? 0} Bs`;

data.insumos.forEach(e => {
    document.getElementById("insumosAdquridos").innerHTML += `
        <tr class="insumo">
            <td>${e.insumo_nombre}</td>
            <td>${e.unidades}</td>
            <td>$${e.precio_unit_usd}</td>
            <td>$${e.precio_total_usd}</td>
            <td>${convertCurrencyToVES(e.precio_unit_bs)} Bs</td>
            <td>${convertCurrencyToVES(e.precio_total_bs)} Bs</td>
        </tr>
    `
})

window.print();