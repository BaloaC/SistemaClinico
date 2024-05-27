import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consulta`,id);

console.log(dataFactura);

document.getElementById("fecha").textContent = formatToRealDate(dataFactura.fecha_consulta);
document.getElementById("recibo_id").textContent = dataFactura.factura_consulta_id;
document.getElementById("nombre_paciente").textContent = `${dataFactura.nombre_paciente} ${dataFactura.apellidos}`;
// document.getElementById("cedula_paciente").textContent = dataFactura.cedula;
// document.getElementById("cedula_titular").textContent = dataFactura.cedula;
// document.getElementById("nombre_medico").textContent = `${dataFactura.nombre_medico} ${dataFactura.apellidos_medico}`;
// document.getElementById("especialidad").textContent = dataFactura.nombre_especialidad;
document.getElementById("metodo_pago").textContent = dataFactura.metodo_pago;
document.getElementById("pago_total_bs").textContent = `${convertCurrencyToVES(dataFactura.monto_total_bs ?? dataFactura.monto_consulta_bs)} Bs`;
document.getElementById("pago_total_usd").textContent = `$${dataFactura.monto_total_usd ?? dataFactura.monto_consulta_usd}`;


window.print();