import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById(`factura/compra`,id);

document.getElementById("proveedor").textContent = data.proveedor_nombre;
document.getElementById("factura_id").textContent = data.factura_compra_id;
document.getElementById("monto_sin_iva").textContent = `$${data.monto_sin_iva}`;
document.getElementById("monto_con_iva").textContent = `$${data.monto_con_iva}`;
document.getElementById("fecha_compra").textContent = data.fecha_compra.split(" ")[0];
document.getElementById("excento").textContent = `$${data.excento}`;

data.insumos.forEach(e => {
    document.getElementById("insumosAdquridos").innerHTML += `
        <tr class="insumo">
            <td>${e.insumo_nombre}</td>
            <td>${e.unidades}</td>
            <td>$${e.precio_unit_usd}</td>
            <td>$${e.precio_total_usd}</td>
        </tr>
    `
})

window.print();