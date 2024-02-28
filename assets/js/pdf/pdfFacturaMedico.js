import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("factura/medico",id);

document.getElementById("fecha").textContent = data.fecha_pago;
document.getElementById("fecha_emision").textContent = data.fecha_emision;
document.getElementById("sumatoria_consultas_aseguradas").textContent = data.sumatoria_consultas_aseguradas;
document.getElementById("sumatoria_consultas_naturales").textContent = data.sumatoria_consultas_naturales;
document.getElementById("nombre").textContent = `${data.nombre} ${data.apellidos}`;
document.getElementById("pacientes").textContent = data.pacientes_consulta;
document.getElementById("pacientes_seguro").textContent = data.pacientes_seguro;
document.getElementById("consultas").textContent = `$${data.acumulado_consulta_total}`;
document.getElementById("consultas_seguro").textContent = `$${data.acumulado_seguro_total}`;
document.getElementById("pago_total").textContent = `$${data.pago_total}`;


window.print();