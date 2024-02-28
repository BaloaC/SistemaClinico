import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4];

const infoFactura = await getAll(`factura/mensajeria/${data}`);
let consultas = "";

console.log(infoFactura);

if(infoFactura.consultas?.length > 0){

    infoFactura.consultas.forEach((consulta, iterator) => {
        consultas += `
            <tr>
                <td>${iterator + 1}</td>
                <td>${consulta.factura_mensajeria_consultas_id}</td>
                <td>${consulta.fecha_ocurrencia}</td>
                <td>${consulta.beneficiado.cedula}</td>
                <td>${consulta.titular.cedula}</td>
                <td>${consulta.beneficiado.nombre} ${consulta.beneficiado.apellidos}</td>
                <td>${convertCurrencyToVES(consulta.monto_consulta_bs)} Bs</td>
            </tr>
        `;
    });

    consultas += `
        <tr>
            <td><br></td>
            <td><br></td>
            <td><br></td>
            <td><br></td>
            <td><br></td>
            <td>Total Bs:</td>
            <td>${infoFactura.total_mensajeria_bs} Bs</td>
        </tr>
    `;
}

document.getElementById("consultas").innerHTML = consultas;
document.getElementById("seguro").textContent = infoFactura.consultas[0].nombre_seguro;
document.getElementById("rif").textContent = infoFactura.consultas[0].rif_seguro;
document.getElementById("fecha").textContent = `Fecha: ${infoFactura.fecha_mensajeria}`;

window.print();