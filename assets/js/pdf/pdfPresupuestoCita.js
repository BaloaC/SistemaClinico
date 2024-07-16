import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

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
document.getElementById("seguroNombre").innerText = data?.cita_seguro[0]?.nombre_seguro.toUpperCase();
document.getElementById("examenesUsd").innerText = `$${examenMonto}`;
document.getElementById("consultaUsd").innerText = `$${data.costo_especialidad}`;
document.getElementById("totalUsd").innerText = `$${data.costo_especialidad + examenMonto}`;

if(data.tipo_servicio == 1) document.querySelector(".consultaMontos").style = "display:none";

window.print();