import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consultaSeguro`,id);

console.log(dataFactura);

document.getElementById("recibo_id").textContent = dataFactura.consulta_seguro_id;
document.getElementById("fecha").textContent = formatToRealDate(dataFactura.fecha_ocurrencia);
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
document.getElementById("total_consultas").textContent = dataFactura.factura?.consultas_medicas_bs ? `${convertCurrencyToVES(dataFactura.factura?.consultas_medicas_bs)} Bs` : `${convertCurrencyToVES(dataFactura.monto_consulta_bs)} Bs`;
document.getElementById("monto_total_consulta").textContent = dataFactura?.monto_consulta_bs ? `${convertCurrencyToVES(dataFactura?.monto_consulta_bs ?? 0)} Bs` : `${convertCurrencyToVES(dataFactura.monto_total_bs ?? 0)} Bs`;
document.getElementById("cobertura").textContent = dataFactura?.cobertura_seguro;
document.getElementById("diferenciaPaciente").textContent = parseFloat(dataFactura?.monto_consulta_usd) - parseFloat(dataFactura?.cobertura_seguro);

window.print();