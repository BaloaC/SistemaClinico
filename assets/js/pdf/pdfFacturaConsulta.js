import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consulta`,id);
const dataConsulta = await getById(`consultas`,dataFactura.consulta_id)

console.log(dataConsulta, dataFactura);

document.getElementById("fecha").textContent = dataConsulta.fecha_consulta;
document.getElementById("nombre_paciente").textContent = `${dataConsulta.nombre_paciente} ${dataConsulta.apellido_paciente}`;
document.getElementById("cedula_paciente").textContent = dataConsulta.cedula_paciente;
document.getElementById("cedula_titular").textContent = dataConsulta.cedula_titular ?? dataConsulta.cedula_paciente;
document.getElementById("nombre_medico").textContent = `${dataConsulta.nombre_medico} ${dataConsulta.apellidos_medico}`;
document.getElementById("especialidad").textContent = dataConsulta.nombre_especialidad;
document.getElementById("metodo_pago").textContent = dataFactura.metodo_pago;
document.getElementById("pago_total_bs").textContent = `${dataFactura.monto_total_bs} Bs`;
document.getElementById("pago_total_usd").textContent = `${dataFactura.monto_total_usd}$`;


window.print();