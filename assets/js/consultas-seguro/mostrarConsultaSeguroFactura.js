import concatItems from "../global/concatItems.js";
import { removeAddAnalist } from "../global/validateRol.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

export const registerStatusConsulta = {
    successfulConsulta: false,
};

addEventListener("DOMContentLoaded", async e => {

    // Ocultar botones de acuerdo a los roles
    removeAddAnalist();

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const consultaSeguroColumns = [
        {
            "className": 'dt-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        {data: "consulta_seguro_id"},
        {
            data: null,
            render: function (data, type, row) {
                if ("cedula_paciente" in data) return data.cedula_paciente;
                else if ("beneficiado" in data) return data.beneficiado.cedula;
                else if ("paciente_beneficiado" in data) return data.paciente_beneficiado.cedula;
                else { return "Consulta por emergencia" }
            }

        },
        {
            data: null,
            render: function (data, type, row) {

                if ("nombre_paciente" in data) return `${data.nombre_paciente} ${data.apellido_paciente}`;
                else if ("beneficiado" in data) return `${data.beneficiado.nombre} ${data.beneficiado.apellidos}`;
                else if ("paciente_beneficiado" in data) return `${data.paciente_beneficiado.nombre} ${data.paciente_beneficiado.apellidos}`;
                else {
                    return "Consulta por emergencia"
                }
            }
        },
        {
            data: null,
            render: function (data, type, row) {

                if ("nombre_especialidad" in data) {
                    return data.nombre_especialidad;
                } else if ("medico" in data && data.medico?.length > 0) {
                    return `${data.medico[0].nombre_especialidad}`;
                } else if ("especialidad" in data) {
                    return `${data.especialidad.nombre}`
                } else {
                    return "Consulta por emergencia"
                }
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                if ("cedula_paciente" in data) return data.cedula_paciente;
                else if ("titular" in data) return data.titular.cedula;
                else if ("cedula_titular" in data) return data.cedula_titular;
                else if ("paciente_titular" in data) return data.paciente_titular.cedula;
                else {
                    return "Consulta por emergencia"
                }
            }
        },
        {
            data: "fecha_ocurrencia",
            render: function (data, type, row) {
                return formatToRealDate(data);
            }
        },
    ];

    const order = [[5, 'desc']];

    const format = (data) => {

        if (data.clave == null && data?.cita?.tipo_cita != 2) data.clave = "No aplica";
        if (data.clave == null && data?.cita?.tipo_cita == 2) data.clave = "Desconocida";
        let tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";
        if (data.es_emergencia === 1) tipo_cita = "Asegurada";

        let examenes = data?.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data?.insumos !== undefined ? concatItems(data?.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data?.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación",
            referidos = data?.referidos !== undefined ? concatItems(data.referidos, "nombre", "No se refirió a ningún médico", ".") : "No se refirió a ningún médico",
            cita_examenes = data?.cita_examenes !== undefined ? concatItems(data.cita_examenes, "nombre", "No se realizó a ningún exámen por cita", ".", "precio_examen_usd", "(Cubierto por el paciente)") : "No se realizó a ningún exámen por cita";


        let recipes = "";
        let factura = "";

        if(data?.consulta?.es_emergencia === 1){
            delete data?.consulta?.tipo_servicio;
        }

        if (data.recipes) {

            recipes = `
                <tr class="py-3">
                    <td colspan="4">Recipes:</td>
                </tr>
            `;

            data.recipes.forEach(el => {
                
                let tipo_medicamento = "";

                if (el.tipo_medicamento == 1) {
                    tipo_medicamento = "Cápsula";
                } else if (el.tipo_medicamento == 2) {
                    tipo_medicamento = "Jarabe";
                } else if (el.tipo_medicamento == 3) {
                    tipo_medicamento = "Inyección";
                } else if (el.tipo_medicamento == 4) {
                    tipo_medicamento = "Solución";
                } else {
                    tipo_medicamento = "Desconocido";
                }

                recipes += `
                <tr>
                    <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
                    <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
                    <td colspan"2">Uso: <br><b>${el.uso}</b></td>
                </tr>
            `;
            })
        } else {
            recipes += ``;
        }

        if (data.factura) {

            factura = `
            <tr class="py-3">
                <td colspan="4"><b>Recibo consulta emergencia</b></td>
            </tr>
            `;

            // <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
            // <td class="pe-4">Cantidad de consultas médicas: <br><b>${data.factura.cantidad_consultas_medicas}</b></td>

            factura += `
            <tr>
                <td class="pe-4">Consultas médicas: <br><b>$${data.factura.consultas_medicas}</b></td>
                <td class="pe-4">Cantidad laboratorio: <br><b>${data.factura.cantidad_laboratorios}</b></td>
                <td class="pe-4">Laboratorios: <br><b>$${data.factura.laboratorios}</b></td>
            </tr>
            <tr>
                
                <td>Medicamentos: <br><b>$${data.factura.medicamentos}</b></td>
                <td>Area de observación: <br><b>$${data.factura.area_observacion}</b></td>
                <td>Enfermería: <br><b>$${data.factura.enfermeria}</b></td>
            </tr>
            <tr>
                <td>Total insumos: <br><b>$${data.factura.total_insumos}</b></td>
                <td>Total exámenes: <br><b>$${data.factura.total_examenes}</b></td>
                <td>Total consulta: <br><b>$${data.factura.total_consulta}</b></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td colspan="4"><b>Monto en bs:</b></td>
            </tr>
             <tr>
                <td>Consultas médicas: <br><b>${data.factura.consultas_medicas_bs} Bs</b></td>
                <td>Laboratorios: <br><b>${data.factura.laboratorios_bs} Bs</b></td>
            </tr>
            <tr>
                <td>Medicamentos: <br><b>${data.factura.medicamentos_bs} Bs</b></td>
                <td>Area de observación: <br><b>${data.factura.area_observacion_bs} Bs</b></td>
                <td>Enfermería: <br><b>${data.factura.enfermeria_bs} Bs</b></td>
            </tr>
            <tr>
                <td>Total insumos: <br><b>${data.factura.total_insumos_bs} Bs</b></td>
                <td>Total exámenes: <br><b>${data.factura.total_examenes_bs} Bs</b></td>
                <td>Total consulta: <br><b>${data.factura.total_consulta_bs} Bs</b></td>
            </tr>
        `;
        }

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px>
                <tr class="py-3">
                    ${data.consulta.peso ? `<td>Peso: <br><b>${data.consulta.peso + " " + "kg"}</b></td>` : ""} 
                    ${data.consulta.altura ? `<td>Estatura: <br><b>${data.consulta.altura + " " + "m"}</b></td>` : ""}
                    ${data.consulta.es_emergencia != 1 && data?.fecha_cita
                    ? `<td>Fecha Cita: <br><b>${formatToRealDate(data.fecha_cita) ?? "No aplica"}</b></td>
                        <td>Motivo cita: <br><b>${data.motivo_cita ?? "No aplica"}</b></td>
                        <td>Clave: <br><b>${data.clave}</b></td>`
                    : ""
                }
                </tr>
                <tr class="py-3">
                    ${data.consulta.tipo_servicio ? `<td class="pe-4 py-3">Tipo de servicio: <br><b>${data?.consulta?.tipo_servicio == 1 ? "Exámenes" : "Consulta"}</b></td>` : ""}
                    ${data.monto_consulta_bs ? `<td class="pe-4 py-3">Monto consulta BS: <br><b>$${data.monto_consulta_bs}</b></td>` : ""}
                    ${data.monto_consulta_usd ? `<td class="pe-4 py-3">Monto consulta USD: <br><b>$${data.monto_consulta_usd}</b></td>` : ""}
                </tr>
                <tr class="blue-td">
                    ${examenes !== "No se realizó ningún exámen" ? `<td class="py-3">Exámenes realizados: <br><b>${examenes}</b></td>` : ""}
                    ${data.consulta.es_emergencia === 1 && insumos !== "No se utilizó ningún insumo" ? `<td class="py-3">Insumos utilizados: <br><b>${insumos}</b></td>` : ""}
                </tr>
                <tr>
                    ${indicaciones !== "No se realizó ninguna indicación" ? `<td class="py-3">Indicaciones: <br><b>${indicaciones}</b></td>` : ""}
                    ${referidos !== "No se refirió a ningún médico" ? `<td class="py-3">Referidos a otro médico: <br><b>${referidos}</b></td>` : ""} 
                    ${cita_examenes !== "No se realizó a ningún exámen por cita" ? `<td class="py-3">Exámenes por citas: <br><b>${cita_examenes}</b></td>` : ""} 
                </tr>
                ${recipes}
                ${factura}
                <tr>
                    <td><a class="btn btn-sm btn-add text-nowrap mb-3" href="#" onclick="${data?.consulta?.es_emergencia == 1 ? "openPopup('pdf/consultaemergencia/" + data?.consulta_seguro_id + "')" : "openPopup('pdf/consultaseguro/" + data?.consulta_seguro_id + "')"}"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
                </tr>
            </table>
        `
    }

    createDataTable({
        id: "#consultas",
        url: `/${path[1]}/factura/consultaSeguro/consulta?con_clave=1`,
        columns: consultaSeguroColumns,
        order,
        format,
        dom: "Plfrtip",
        formatDataCustom: true,
        formatDataCustomUrl: "factura/consultaSeguro",
        formatDataCustomId: "consulta_seguro_id",
        formatDataCustomUrl2: "consultas",
        formatDataCustomId2: "consulta_id",
        processing: true,
        serverSide: true
    });

});