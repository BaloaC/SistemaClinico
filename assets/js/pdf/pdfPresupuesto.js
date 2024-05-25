import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("consultas/",id);
console.log("🍓 ~ file: pdfPresupuesto.js:6 ~ data:", data)

const seguroInfo = await getById("seguros/", data[0].factura.seguro_id);
// console.log("🍓 ~ file: pdfPresupuesto.js:7 ~ titularInfo:", titularInfo)


document.getElementById("nombrePaciente").innerText = `${data[0].beneficiado.nombre} ${data[0].beneficiado.apellidos}`.toUpperCase();
document.getElementById("cedulaPaciente").innerText = data[0].beneficiado.cedula;
document.getElementById("nombreTitular").innerText = `${data[0].titular.nombre} ${data[0].titular.apellidos}`.toUpperCase();
document.getElementById("cedulaTitular").innerText = data[0].titular.cedula;
// document.getElementById("empresaNombre").innerText = ;
document.getElementById("seguroNombre").innerText = seguroInfo.nombre.toUpperCase();
document.getElementById("examenesUsd").innerText = `$${data[0].factura.total_examenes}`;
document.getElementById("examenesBs").innerText = `${convertCurrencyToVES(data[0].factura.total_examenes_bs)} Bs`;
document.getElementById("insumoUsd").innerText = `$${data[0].factura.total_insumos}`;
document.getElementById("insumoBs").innerText = `${convertCurrencyToVES(data[0].factura.total_insumos_bs)} Bs`;
document.getElementById("laboratorioUsd").innerText = `$${data[0].factura.laboratorios}`;
document.getElementById("laboratorioBs").innerText = `${convertCurrencyToVES(data[0].factura.laboratorios_bs)}`;
document.getElementById("enfermeriaUsd").innerText = `$${data[0].factura.enfermeria}`;
document.getElementById("enfermeriaBs").innerText = `${convertCurrencyToVES(data[0].factura.enfermeria_bs)} Bs`;
document.getElementById("observacionUsd").innerText = `$${data[0].factura.area_observacion}`;
document.getElementById("observacionBs").innerText = `${convertCurrencyToVES(data[0].factura.area_observacion_bs)} Bs`;
document.getElementById("totalUsd").innerText = `$${data[0].factura.total_consulta}`;
document.getElementById("totalBs").innerText = `${convertCurrencyToVES(data[0].factura.total_consulta_bs)} Bs`;

window.print();