import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";


const a = {
    "nombre_paciente": "Juan",
    "apellido_paciente": "Delgado",
    "cedula_paciente": "2145654",
    "nombre_medico": "Daniela",
    "apellido_medico": "Mandez",
    "nombre_especialidad": "Oftamología",
    "cita_id": 5,
    "paciente_id": 3,
    "medico_id": 3,
    "especialidad_id": 6,
    "fecha_cita": "2024-06-26",
    "hora_entrada": "07:10:00",
    "hora_salida": "07:40:00",
    "motivo_cita": "Control",
    "cedula_titular": 2145654,
    "tipo_cita": "2",
    "tipo_servicio": "2",
    "estatus_cit": "3",
    "monto_aprobado": 0,
    "costo_especialidad": 25,
    "cita_seguro": [
        {
            "seguro_id": 8,
            "nombre_seguro": "Mercantil Seguros",
            "clave": null
        }
    ],
    "examenes": [
        {
            "cita_examen_id": 3,
            "examen_id": 17,
            "precio_examen_bs": 0,
            "precio_examen_usd": 20,
            "nombre": "Radiografía de Torax"
        }
    ]
}

const id = location.pathname.split("/")[4];
const data = await getById("citas/", id);
console.log("🍓 ~ file: pdfPresupuesto.js:6 ~ data:", data)


let examenMonto = 0;

// Calcular monto del examen
if (data.examenes && data.examenes.length > 0) data.examenes.map(examen => examenMonto += examen.precio_examen_usd ) 

console.log(data.costo_especialidad, data.examenMonto, data.costo_especialidad + data.examenMonto)

document.getElementById("nombrePaciente").innerText = `${data.nombre_paciente} ${data.apellido_paciente}`.toUpperCase();
document.getElementById("cedulaPaciente").innerText = data.cedula_paciente;
// document.getElementById("nombreTitular").innerText = `${data[0].titular.nombre} ${data[0].titular.apellidos}`.toUpperCase();
// document.getElementById("cedulaTitular").innerText = data[0].titular.cedula;
document.getElementById("montoAprobado").innerText = data.monto_aprobado;
// document.getElementById("empresaNombre").innerText = data[0].empresas[0].nombre.toUpperCase();
document.getElementById("procesadorPor").innerText = Cookies.get("nombreUsuario").toUpperCase();
document.getElementById("seguroNombre").innerText = data.cita_seguro[0].nombre_seguro.toUpperCase();
document.getElementById("examenesUsd").innerText = `$${examenMonto}`;
document.getElementById("consultaUsd").innerText = `$${data.costo_especialidad}`;
document.getElementById("totalUsd").innerText = `$${data.costo_especialidad + examenMonto}`;

window.print();