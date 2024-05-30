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
    console.log("🍓 ~ file: mostrarConsultaSeguroFactura.js:88 ~ format ~ data:", data)


        if (data.clave == null && data?.cita?.tipo_cita != 2) data.clave = "No aplica";
        if (data.clave == null && data?.cita?.tipo_cita == 2) data.clave = "Desconocida";
        let tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";
        if (data.es_emergencia === 1) tipo_cita = "Asegurada";

        let examenes = data?.consultas[0]?.examenes !== undefined ? concatItems(data.consultas[0].examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data?.consultas[0]?.insumos !== undefined ? concatItems(data.consultas[0].insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data?.consultas[0]?.indicaciones !== undefined ? concatItems(data.consultas[0].indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación",
            referidos = data?.consultas[0]?.referidos !== undefined ? concatItems(data.consultas[0].referidos, "nombre", "No se refirió a ningún médico", ".") : "No se refirió a ningún médico",
            cita_examenes = data?.cita_examenes !== undefined ? concatItems(data.cita_examenes, "nombre", "No se realizó a ningún exámen por cita", ".") : "No se realizó a ningún exámen por cita";


        let recipes = `
        <tr>
            <td colspan="4">Recipes:</td>
        </tr>
        `;
        let factura = "";

        if (data.recipes) {

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
            recipes += `
            <tr>
                <td colspan="4"><b>No hay recipes asigandos</b></td>
            </tr>
            `;
        }

        if (data.factura) {

            factura = `
            <tr>
                <td colspan="4"><b>Factura consulta emergencia:</b></td>
            </tr>
            `;

            factura += `
            <tr>
                <td>Cantidad de consultas médicas: <br><b>${data.factura.cantidad_consultas_medicas}</b></td>
                <td>Consultas médicas: <br><b>$${data.factura.consultas_medicas}</b></td>
                <td>Cantidad laboratorio: <br><b>${data.factura.cantidad_laboratorios}</b></td>
                <td>Laboratorios: <br><b>$${data.factura.laboratorios}</b></td>
            </tr>
            <tr>
                <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
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
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Peso: <br><b>${data?.consulta?.peso ? data?.consulta?.peso + " " + "kg" : "No especificado"} </b></td>
                    <td>Estatura: <br><b>${data?.consulta?.altura ? data?.consulta?.altura + " " + "m" : "No especificado"}</b></td>
                    <td>Fecha Cita: <br><b>${formatToRealDate(data?.cita?.fecha_cita) ?? "No aplica"}</b></td>
                    <td>Motivo cita: <br><b>${data?.cita?.motivo_cita ?? "No aplica"}</b></td>
                </tr>
                <tr class="blue-td">
                    <td>Clave: <br><b>${data.clave}</b></td>
                    <td>Exámenes realizados: <br><b>${examenes}</b></td>
                    <td>Insumos utilizados: <br><b>${insumos}</b></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td>Indicaciones: <br><b>${indicaciones}</b></td>
                    <td>Exámenes por citas: <br><b>${cita_examenes}</b></td>
                    <td>Referidos: <br><b>${referidos}</b></td>
                </tr>
                <tr><td><br></td></tr>
                ${recipes}
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                ${factura}
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add text-nowrap mb-3" href="#" onclick="${data?.consulta?.es_emergencia == 1 ? "openPopup('pdf/consultaemergencia/" + data?.consulta_seguro_id + "')" : "openPopup('pdf/consultaseguro/" + data?.consulta_id + "')"}"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
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