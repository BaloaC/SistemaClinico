import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const id = location.pathname.split("/")[4];
const dataFactura = await getById(`factura/consultaSeguro`,id);

console.log(dataFactura);

document.getElementById("recibo_id").textContent = dataFactura.consulta_seguro_id;
document.getElementById("fecha").textContent = formatToRealDate(dataFactura.fecha_ocurrencia);
document.getElementById("nombre_seguro").textContent = dataFactura.seguro?.nombre ?? "Desconocido";
document.getElementById("rif").textContent = dataFactura.seguro?.rif ?? "Desconocido";
document.getElementById("direccion").textContent = dataFactura.seguro?.direccion ?? "Desconocida";
document.getElementById("total_insumos").textContent = dataFactura.factura?.total_insumos_bs ?? "-";
// document.getElementById("total_examenes").textContent = dataFactura.factura?.total_examenes ?? "-";
document.getElementById("cant_laboratorio").textContent = dataFactura.factura?.cantidad_laboratorios ?? "-";
document.getElementById("total_laboratorio").textContent = dataFactura.factura?.laboratorios_bs ?? "-";
document.getElementById("area_observacion").textContent = dataFactura.factura?.area_observacion_bs ?? "-";
document.getElementById("cant_medicamentos").textContent = dataFactura.factura?.cantidad_medicamentos ?? "-";
document.getElementById("total_medicamentos").textContent = dataFactura.factura?.medicamentos_bs ?? "-";
document.getElementById("enfermeria").textContent = dataFactura.factura?.enfermeria_bs ?? "-";
document.getElementById("cant_consultas").textContent = dataFactura.factura?.cantidad_consultas_medicas ?? "-";
document.getElementById("total_consultas").textContent = dataFactura.factura?.consultas_medicas_bs ? `${convertCurrencyToVES(dataFactura.factura?.consultas_medicas_bs)} Bs` : `${convertCurrencyToVES(dataFactura.monto_consulta_bs)} Bs`;
document.getElementById("monto_total_consulta").textContent = dataFactura?.monto_consulta_bs ? `${convertCurrencyToVES(dataFactura?.monto_consulta_bs ?? 0)} Bs` : `${convertCurrencyToVES(dataFactura.monto_total_bs ?? 0)} Bs`;
document.getElementById("cobertura").textContent = Math.abs(dataFactura?.cobertura_seguro);
document.getElementById("diferenciaPaciente").textContent = Math.abs(parseFloat(dataFactura?.monto_total_usd) - parseFloat(dataFactura?.cobertura_seguro));
document.getElementById("procesadoPor").innerText = Cookies.get("nombreUsuario").toUpperCase();
document.getElementById("nombrePaciente").textContent = `${dataFactura?.beneficiado?.nombre} ${dataFactura?.beneficiado?.apellidos}`;
document.getElementById("cedulaPaciente").innerText = dataFactura.beneficiado.cedula;

if(dataFactura?.examenes && dataFactura?.examenes.length > 0) {
    let examenes = "";

    dataFactura.examenes.forEach(examen => {

        examenes += `
            <tr class="insumos-head">
                <th>${examen.nombre}</th>
                <th></th>
                <th id="cant_medicamentos"></th>
                <th id="total_medicamentos">${examen.precio_examen_bs}</th>
            </tr>
        `;
    })

    console.log(examenes);
    document.querySelector(".examenesRealizados").insertAdjacentHTML("afterend", examenes);
}

window.print();