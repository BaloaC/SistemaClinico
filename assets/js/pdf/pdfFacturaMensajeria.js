import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4];

const infoFactura = await getAll(`factura/mensajeria/${data}`);
let consultas = "";

console.log(infoFactura);

if(infoFactura.consultas?.length > 0){

    infoFactura.consultas.forEach(consulta => {
        consultas += `
            <tr>
                <td>${consulta.factura_mensajeria_consultas_id}</td>
                <td>${consulta.fecha_ocurrencia}</td>
                <td>${consulta.paciente_beneficiado.cedula}</td>
                <td>${consulta.paciente_titular.cedula}</td>
                <td>${consulta.paciente_beneficiado.nombre} ${consulta.paciente_beneficiado.apellidos}</td>
                <td>${consulta.monto_consulta_bs}</td>
            </tr>
        `;
    });

    consultas += `
        <tr>
            <td><br></td>
            <td><br></td>
            <td><br></td>
            <td><br></td>
            <td>Total Bs:</td>
            <td>${infoFactura.total_mensajeria_bs}</td>
        </tr>
    `;
}

document.getElementById("consultas").innerHTML = consultas;
document.getElementById("seguro").textContent = infoFactura.consultas[0].nombre_seguro;
document.getElementById("rif").textContent = infoFactura.consultas[0].rif_seguro;
document.getElementById("fecha").textContent = `Fecha: ${infoFactura.fecha_mensajeria}`;

window.print();