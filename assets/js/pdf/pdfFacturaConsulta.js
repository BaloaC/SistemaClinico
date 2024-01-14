import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consulta`,id);

console.log(dataFactura);

document.getElementById("fecha").textContent = dataFactura.fecha_consulta;
document.getElementById("nombre_paciente").textContent = `${dataFactura.nombre_paciente} ${dataFactura.apellidos}`;
document.getElementById("cedula_paciente").textContent = dataFactura.cedula;
document.getElementById("cedula_titular").textContent = dataFactura.cedula;
document.getElementById("nombre_medico").textContent = `${dataFactura.nombre_medico} ${dataFactura.apellidos_medico}`;
document.getElementById("especialidad").textContent = dataFactura.nombre_especialidad;
document.getElementById("metodo_pago").textContent = dataFactura.metodo_pago;
document.getElementById("pago_total_bs").textContent = `${dataFactura.monto_consulta_bs} Bs`;
document.getElementById("pago_total_usd").textContent = `$${dataFactura.monto_consulta_usd}`;


window.print();