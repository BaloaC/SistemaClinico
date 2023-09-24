import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4].split("-");

const infoCintillo = await getAll(`factura/seguro/fecha?seguro=${data[0]}&anio=${data[1]}&mes=${data[2]}`);
let consultas = "";

if(infoCintillo.consultas?.length > 0){

    infoCintillo.consultas.forEach(consulta => {
        consultas += `
            <tr>
                <td>${consulta.consulta_seguro_id}</td>
                <td>${consulta.fecha_ocurrencia}</td>
                <td>${consulta?.especialidad?.nombre ?? "Desconocido"}</td>
                <td>${consulta.paciente_beneficiado.nombre} ${consulta.paciente_beneficiado.apellidos}</td>
                <td>${consulta.paciente_beneficiado.cedula}</td>
                <td>${consulta.tipo_servicio}</td>
                <td>${consulta.monto_consulta_usd}</td>
            </tr>
        `;
    });
}

document.getElementById("consultas-seguros").innerHTML = consultas;
document.getElementById("seguro").textContent = infoCintillo.factura[0].nombre;
document.getElementById("rif").textContent = infoCintillo.factura[0].rif;

window.print();