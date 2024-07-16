import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import concatItems from "../global/concatItems.js";
import formatToRealDate from "../global/formatToRealDate.js";
import { removeActAnalist, removeDeleteAnalist } from "../global/validateRol.js";
import createDataTable from "../global/createDataTable.js";

export let infoSeguro;
export let examenesSeguroListAll;
removeActAnalist();
removeDeleteAnalist();

export async function getConsultasSegurosMes({ seguro = "", anio = "", mes = "" } = {}) {


    const nombreSeguro = document.getElementById("nombreSeguro");
    const rifSeguro = document.getElementById("rifSeguro");
    const telSeguro = document.getElementById("telSeguro");
    const direcSeguro = document.getElementById("direcSeguro");
    const porcentajeSeguro = document.getElementById("porcentajeSeguro");
    const costoSeguro = document.getElementById("costoConsultaSeguro");
    const precioExamanes = document.getElementById("precioExamanes");
    const seguroPrecioInput = document.getElementById("seguro_precio_id");
    const btnAddExamen = document.getElementById("btn-addExamen");
    const btnDelete = document.getElementById("btn-confirmDeleteSeguro");
    infoSeguro = await getById("seguros", seguro);
    examenesSeguroListAll = await getAll("examenes/consulta");

    nombreSeguro.textContent = infoSeguro.nombre;
    rifSeguro.textContent = infoSeguro.rif;
    telSeguro.textContent = infoSeguro.telefono;
    direcSeguro.textContent = infoSeguro.direccion;
    porcentajeSeguro.textContent = `${infoSeguro.porcentaje}%`;
    costoSeguro.textContent = `$${infoSeguro.costo_consulta}`;
    btnDelete.setAttribute("onclick", `deleteSeguro(${infoSeguro.seguro_id})`);
    seguroPrecioInput.value = infoSeguro.seguro_id;

    let examenesList = "";
    precioExamanes.replaceChildren();

    infoSeguro?.examenes?.forEach(examen => {
        examenesList += `
        <div class="row align-items-center">
            <div class="col-3 col-md-1 px-1">
                <button type="button" class="btn" value="${examen.examen_id}" data-bs-toggle="modal" data-bs-target="#modalDeletePrecioExamen" onclick="deletePrecioExamen(this, ${infoSeguro.seguro_id})"><i class="fas fa-times m-0"></i></button>
            </div>
            <div class="col-12 col-md-5">
                <label for="titular">Nombre</label>
                <select class="form-control mb-3" data-active="0" required disabled>
                    <option value="" selected>${examen.nombre}</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Precio</label>
                <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3" required disabled>
                    <option value="" selected>${examen.precio_examen_seguro}$</option>
                </select>
            </div>
        </div>
        `;
    });

    // Si no hay exámenes por añadir, mostramos una alerta que diga ya no hay más exámenes por añadir
    if (examenesSeguroListAll.length == infoSeguro?.examenes.length || examenesSeguroListAll.length == 0) {

        const alertMessage = document.getElementById("alertMessage");
        alertMessage.textContent = "No hay exámenes por registrar disponibles o el seguro ya posee el precio de todos los exámenes registrados";
        alertMessage.classList.remove("d-none");

        btnAddExamen.setAttribute("data-bs-target", "#modalAlert");
    } else {
        btnAddExamen.setAttribute("data-bs-target", "#modalAddPrecioExamen");
    }

    // Si el seguro tiene precio de exámenes lo mostramos, de lo contrario mostramos una alerta de que no posee
    if (examenesList !== "") {
        precioExamanes.innerHTML = examenesList;
    } else {
        precioExamanes.innerHTML = `<div class="alert alert-warning" role="alert">Este seguro no cuenta con ningún exámen registrado</div>`;
    }

    // Ocultar datos de la factura antes de la petición
    $(".factura-header").fadeOut("slow");
    $(".total-amount").fadeOut("slow");


    let listConsultas = await getAll(`factura/seguro/fecha?seguro=${seguro}&anio=${anio}&mes=${mes}`);

    // Datos facturas
    const montoTotal = document.getElementById("total-price");
    const idRecibo = document.getElementById("factura_id");
    const mesRecibo = document.getElementById("mes-factura");
    const fechaOcurrencia = document.getElementById("fecha-ocurrencia");
    const fechaVencimiento = document.getElementById("fecha-vencimiento");
    const estatusFactura = document.getElementById("factura-estatus");
    const btnCintillo = document.getElementById("btn-cintillo-pdf");

    if (listConsultas?.factura?.length > 0) {

        idRecibo.textContent = listConsultas.factura[0].factura_seguro_id;
        mesRecibo.textContent = listConsultas.factura[0].mes;
        fechaOcurrencia.textContent = formatToRealDate(listConsultas.factura[0].fecha_ocurrencia.split(" ")[0]);
        fechaVencimiento.textContent = formatToRealDate(listConsultas.factura[0].fecha_vencimiento);
        montoTotal.textContent = `$${listConsultas.factura[0].monto_usd}`;

        // Si hay consultas disponibles mostrar el boton del pdf
        if (listConsultas.consultas?.length > 0) {
            btnCintillo.setAttribute("onclick", `openPopup('pdf/cintillo/${seguro}-${anio}-${mes}')`)
            $("#btn-cintillo-pdf").fadeIn("slow");
        } else {
            $("#btn-cintillo-pdf").fadeOut("slow");
        }

        // Si la factura está pagada o pendiente rellenar este campo de fecha con dicho estatus
        if (listConsultas.factura[0].estatus_fac == 1) {
            estatusFactura.innerHTML = '<span class="badge light badge-warning">Pendiente</span>';
        } else {
            estatusFactura.innerHTML = '<span class="badge light badge-success">Pagada</span>';
        }

        $(".factura-header").fadeIn("slow");
        $(".card-body").fadeIn("slow");
        $(".total-amount").fadeIn("slow");
        $("#factura-doesnt-exist").fadeOut("slow");

        window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);

    } else {
        listConsultas = [];

        $(".factura-header").fadeOut("slow");
        $(".card-body").fadeOut("slow");
        $(".total-amount").fadeOut("slow");
        $("#factura-doesnt-exist").fadeIn("slow");
        return;
    }


    $('#consultaSeguro').DataTable().clear();
    $('#consultaSeguro').DataTable().destroy();

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
                if (data.beneficiado && data.beneficiado.cedula) {
                    return data.beneficiado.cedula;
                } else if (data.paciente_beneficiado && data.paciente_beneficiado.cedula) {
                    return data.paciente_beneficiado.cedula;
                } else {
                    return 'Desconocido';
                }
            }
        },
        {
            data: null,
            render: function (data, type, row) {

                if (data.especialidad && data.especialidad.nombre) {
                    return data.especialidad.nombre;
                // } else if (data?.medico[0]?.nombre_especialidad) {
                //     return data?.medico[0]?.nombre_especialidad
                } else {
                    return 'Consulta por emergencia';
                }
            }
        },
        { 
            data: null, 
            render: function (data, type, row){
                return row?.consulta.tipo_servicio == 1 ? "Exámenes" : "Consulta";
            }
        },
        {
            data: "fecha_ocurrencia",
            render: function (data, type, row) {
                return formatToRealDate(data);
            }
        },

        {
            data: null,
            render: function (data, type, row) {

                if (data.monto_consulta_usd != undefined) {
                    return `$${data.monto_consulta_usd}`;
                } else {
                    return "Desconocido";
                }
            }
        },

    ];

    const dataConsultaSeguro = listConsultas.consultas ?? [];

    const columnDefsConsultaSeguro = [
        {
            targets: 5,
            createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
                // Añadir una clase al td
                $(cell).addClass('text-end');
            },

        },
        {
            type: 'datetime-moment',
            targets: 4
        }
    ];

    const order = [[4, 'desc']];

    const format = (data) => {

        const info = {};

        if (data !== undefined) {

            info.data = data;

            if (data.clave == null || data.clave == undefined) data.clave = "No aplica";
            info.tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";

            info.examenes = data.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen";
            info.insumos = data.insumos !== undefined ? concatItems(data.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo";
            info.indicaciones = data.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";
            info.referidos = data?.referidos !== undefined ? concatItems(data.referidos, "nombre", "No se refirió a ningún médico", ".") : "No se refirió a ningún médico",
            info.cita_examenes = data?.cita_examenes !== undefined ? concatItems(data.cita_examenes, "nombre", "No se realizó a ningún exámen por cita", ".", "precio_examen_usd") : "No se realizó a ningún exámen por cita";

            info.recipes = "";
            info.factura = "";

            if (data.recipes) {

                info.recipes = `
                <tr>
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

                    info.recipes += `
                    <tr>
                        <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
                        <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
                        <td colspan"2">Uso: <br><b>${el.uso}</b></td>
                    </tr>
                `;
                })
            } else {
                info.recipes += ``;
            }

            // <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
            //         <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
            //         <td colspan"2">Uso: <br><b>${el.uso}</b></td>

            if (data.factura) {

                info.factura = `
                <tr class="py-3">
                    <td colspan="4"><b>Factura consulta emergencia:</b></td>
                </tr>
                `;

                // <td class="pe-4">Cantidad de consultas médicas: <br><b>${data.factura.cantidad_consultas_medicas}</b></td>
                // <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
    
                info.factura += `
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


            info.paciente_beneficiado = "";

            if (data.paciente_beneficiado) {

                info.paciente_beneficiado = `
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="4"><b>Información paciente beneficiado:</b></td>
                </tr>
                `;

                info.paciente_beneficiado += `
                <tr>
                    <td>Cédula: <br><b>${data.paciente_beneficiado.cedula}</b></td>
                    <td>Nombres: <br><b>${data.paciente_beneficiado.nombre}</b></td>
                    <td>Apellidos: <br><b>${data.paciente_beneficiado.apellidos}</b></td>
                </tr>
                <tr>
                    <td>Fecha de nacimiento: <br><b>${formatToRealDate(data.paciente_beneficiado.fecha_nacimiento)}</b></td>
                    <td>Edad: <br><b>${data.paciente_beneficiado.edad}</b></td>
                </tr>
            `;
            }

            info.medico = "";

            if (data.medico) {

                info.medico = `
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="4"><b>Información médico:</b></td>
                </tr>
                `;

                info.medico += `
                <tr>
                    <td>Cédula: <br><b>${data?.medico?.cedula}</b></td>
                    <td>Nombres: <br><b>${data?.medico?.nombre}</b></td>
                    <td>Apellidos: <br><b>${data?.medico?.apellidos}</b></td>
                </tr>
                <tr>
                    <td>Especialidad: <br><b>${data?.medico[0]?.nombre_especialidad ?? data?.especialidad.nombre}</b></td>
                </tr>
            `;
            }
        }

        return `
        <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px;>
            <tr>
                <td colspan="4"><b>Información consulta:</b></td>
            </tr>
            <tr class="py-3">
                    ${data.consulta.peso ? `<td class="pe-4">Peso: <br><b>${data.consulta.peso + " " + "kg"}</b></td>` : ""} 
                    ${data.consulta.altura ? `<td class="pe-4">Estatura: <br><b>${data.consulta.altura + " " + "m"}</b></td>` : ""}
                    ${data.consulta.es_emergencia != 1 && data?.cita
                    ? `<td class="pe-4">Fecha Cita: <br><b>${formatToRealDate(data?.cita.fecha_cita) ?? "No aplica"}</b></td>
                        <td class="pe-4">Motivo cita: <br><b>${data?.cita.motivo_cita ?? "No aplica"}</b></td>
                        <td class="pe-4">Clave: <br><b>${data?.cita.clave}</b></td>`
                    : ""
                }
            </tr>
            <tr class="py-3">
                ${data.consulta.tipo_servicio ? `<td class="pe-4 py-3">Tipo de servicio: <br><b>${data?.consulta?.tipo_servicio == 1 ? "Exámenes" : "Consulta"}</b></td>` : ""}
                ${data.monto_consulta_usd ? `<td class="pe-4 py-3">Monto consulta BS: <br><b>$${data.monto_consulta_usd}</b></td>` : ""}
                ${data.monto_consulta_bs ? `<td class="pe-4 py-3">Monto consulta USD: <br><b>$${data.monto_consulta_bs}</b></td>` : ""}
            </tr>
            <tr class="blue-td">
                ${info.examenes !== "No se realizó ningún exámen" ? `<td class="py-3 pe-3">Exámenes realizados: <br><b>${info.examenes}</b></td>` : ""}
                ${data.consulta.es_emergencia === 1 && info.insumos !== "No se utilizó ningún insumo" ? `<td class="py-3">Insumos utilizados: <br><b>${info.insumos}</b></td>` : ""}
            </tr>
            <tr>
                ${info.indicaciones !== "No se realizó ninguna indicación" ? `<td class="py-3">Indicaciones: <br><b>${info.indicaciones}</b></td>` : ""}
                ${info.referidos !== "No se refirió a ningún médico" ? `<td class="py-3">Referidos a otro médico: <br><b>${info.referidos}</b></td>` : ""} 
                ${info.cita_examenes !== "No se realizó a ningún exámen por cita" ? `<td class="py-3">Exámenes por citas: <br><b>${info.cita_examenes}</b></td>` : ""} 
            </tr>
            ${info.paciente_beneficiado}
            ${info.medico}
            ${info.factura}
            <tr>
                <td><a class="btn btn-sm btn-add" href="#" onclick="${info?.data?.consulta?.es_emergencia == 1 ? "openPopup('pdf/consultaemergencia/" + info?.data?.consulta_seguro_id + "')" : "openPopup('pdf/consultaseguro/" + info?.data?.consulta_seguro_id + "')"}"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
            </tr>
        </table>
    `

    }

    let consultaSeguroDatatable = createDataTable({
        id: "#consultaSeguro",
        data: dataConsultaSeguro,
        columnDefs: columnDefsConsultaSeguro,
        columns: consultaSeguroColumns,
        order,
        format,
        paging: false,
        info: false,
        scrollX: true,
        scrollY: 350,
        scrollCollapse: true,
        formatDataCustom: true,
        formatDataCustomUrl: "factura/consultaSeguro",
        formatDataCustomId: "consulta_seguro_id"
    });
}

addEventListener("DOMContentLoaded", async e => {

    const urlParams = new URLSearchParams(window.location.search);
    const seguro_id = urlParams.get('seguro');
    const anio = urlParams.get('anio');
    const mes = urlParams.get('mes');

    const btnActualizar = document.getElementById("btn-actualizar");

    btnActualizar.setAttribute("onclick", `updateSeguro(${seguro_id})`);

    getConsultasSegurosMes({ seguro: seguro_id, anio: anio ?? null, mes: mes ?? null });
});

function getConsultasSegurosMesByClick() {
    const urlParams = new URLSearchParams(window.location.search);
    const seguro_id = urlParams.get('seguro');

    // [0] = año | [1] = mes
    const fecha = document.getElementById("month-year-input").value.split("-");

    getConsultasSegurosMes({
        seguro: seguro_id,
        anio: fecha[0],
        mes: fecha[1]
    });
}

window.getConsultasSegurosMesByClick = getConsultasSegurosMesByClick;

document.getElementById("search-button").addEventListener("click", async e => {

})