import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consultaSeguro`,id);

console.log(dataFactura);

document.getElementById("recibo_id").textContent = dataFactura.consulta_seguro_id;
document.getElementById("fecha").textContent = dataFactura.fecha_ocurrencia;
document.getElementById("nombre_seguro").textContent = dataFactura.seguro?.nombre ?? "Desconocido";
document.getElementById("rif").textContent = dataFactura.seguro?.rif ?? "Desconocido";
document.getElementById("direccion").textContent = dataFactura.seguro?.direccion ?? "Desconocida";
document.getElementById("total_insumos").textContent = dataFactura.factura?.total_insumos_bs ?? "-";
document.getElementById("total_examenes").textContent = dataFactura.factura?.total_examenes ?? "-";
document.getElementById("cant_laboratorio").textContent = dataFactura.factura?.cantidad_laboratorios ?? "-";
document.getElementById("total_laboratorio").textContent = dataFactura.factura?.laboratorios_bs ?? "-";
document.getElementById("area_observacion").textContent = dataFactura.factura?.area_observacion_bs ?? "-";
document.getElementById("cant_medicamentos").textContent = dataFactura.factura?.cantidad_medicamentos ?? "-";
document.getElementById("total_medicamentos").textContent = dataFactura.factura?.medicamentos_bs ?? "-";
document.getElementById("enfermeria").textContent = dataFactura.factura?.enfermeria_bs ?? "-";
document.getElementById("cant_consultas").textContent = dataFactura.factura?.cantidad_consultas_medicas ?? "-";
document.getElementById("total_consultas").textContent = dataFactura.factura?.consultas_medicas_bs ? `${dataFactura.factura?.consultas_medicas_bs} Bs` : `${dataFactura.monto_consulta_bs} Bs`;
document.getElementById("monto_total_consulta").textContent = dataFactura?.monto_consulta_bs ? `${dataFactura?.monto_consulta_bs} Bs` : `${dataFactura.monto_total_bs} Bs`;
// document.getElementById("nombre_paciente").textContent = `${dataConsulta[0].nombre_paciente} ${dataConsulta[0].apellido_paciente}`;
// document.getElementById("cedula_paciente").textContent = dataConsulta[0].cedula_paciente;
// document.getElementById("cedula_titular").textContent = dataConsulta[0].cedula_titular;
// document.getElementById("nombre_medico").textContent = `${dataConsulta[0].nombre_medico} ${dataConsulta[0].apellido_medico}`;
// document.getElementById("especialidad").textContent = dataConsulta[0].nombre_especialidad;
// document.getElementById("fecha_ocurrencia").textContent = dataFactura.fecha_ocurrencia;
// document.getElementById("fecha_pago_limite").textContent = dataFactura.fecha_pago_limite;
// document.getElementById("pago_total").textContent = dataFactura.monto;


window.print();