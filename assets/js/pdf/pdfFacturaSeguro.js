import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/seguro`,id);
const dataSeguro = await getById(`seguros`,dataFactura.seguro_id);
const dataConsulta = await getById("consultas",dataFactura.consulta_id);

document.getElementById("fecha").textContent = dataConsulta[0].fecha_consulta;
document.getElementById("seguro").textContent = dataSeguro.nombre;
document.getElementById("nombre_paciente").textContent = `${dataConsulta[0].nombre_paciente} ${dataConsulta[0].apellido_paciente}`;
document.getElementById("cedula_paciente").textContent = dataConsulta[0].cedula_paciente;
document.getElementById("cedula_titular").textContent = dataConsulta[0].cedula_titular;
document.getElementById("nombre_medico").textContent = `${dataConsulta[0].nombre_medico} ${dataConsulta[0].apellido_medico}`;
document.getElementById("especialidad").textContent = dataConsulta[0].nombre_especialidad;
document.getElementById("fecha_ocurrencia").textContent = dataFactura.fecha_ocurrencia;
document.getElementById("fecha_pago_limite").textContent = dataFactura.fecha_pago_limite;
document.getElementById("pago_total").textContent = dataFactura.monto;


window.print();