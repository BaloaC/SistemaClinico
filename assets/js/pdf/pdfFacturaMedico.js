import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("factura/medico",id);

document.getElementById("fecha").textContent = data[0].fecha_pago;
document.getElementById("nombre").textContent = `${data[0].nombre} ${data[0].apellidos}`;
document.getElementById("pacientes").textContent = data[0].pacientes_consulta;
document.getElementById("pacientes_seguro").textContent = data[0].pacientes_seguro;
document.getElementById("consultas").textContent = `$${data[0].acumulado_consulta_total}`;
document.getElementById("consultas_seguro").textContent = `$${data[0].acumulado_seguro_total}`;
document.getElementById("pago_total").textContent = `$${data[0].pago_total}`;


window.print();