import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4].split("-");

const infoCintillo = await getAll(`factura/seguro/fecha?seguro=${data[0]}&anio=${data[1]}&mes=${data[2]}`);
let consultas = "";

if (infoCintillo.consultas?.length > 0) {

    infoCintillo.consultas.forEach(consulta => {

        let [nombrePaciente, cedulaPaciente, especialidad] = ["", "", ""];

        if (consulta?.beneficiado?.nombre) {

            nombrePaciente = `${consulta.beneficiado.nombre} ${consulta.beneficiado.apellidos}`;
            cedulaPaciente = consulta.beneficiado.cedula;
            especialidad = consulta.medico[0]?.nombre_especialidad ?? "Desconocido";

        } else if (consulta?.paciente_beneficiado?.nombre) {

            nombrePaciente = `${consulta.paciente_beneficiado.nombre} ${consulta.paciente_beneficiado.apellidos}`;
            cedulaPaciente = consulta.paciente_beneficiado.cedula;
            especialidad = consulta.especialidad.nombre ?? "Desconocido";

        } else {

            [nombrePaciente, cedulaPaciente, especialidad] = ["Desconocido"];
        }

        console.log(consulta);
        consultas += `
            <tr>
                <td>${consulta.consulta_seguro_id}</td>
                <td>${consulta.fecha_ocurrencia}</td>
                <td>${especialidad}</td>
                <td>${nombrePaciente}</td>
                <td>${cedulaPaciente}</td>
                <td>${consulta.tipo_servicio}</td>
                <td>$${consulta.monto_consulta_usd}</td>
            </tr>
        `;
    });
}

document.getElementById("consultas-seguros").innerHTML = consultas;
document.getElementById("seguro").textContent = infoCintillo.factura[0].nombre;
document.getElementById("rif").textContent = infoCintillo.factura[0].rif;

window.print();