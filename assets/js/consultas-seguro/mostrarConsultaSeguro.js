import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import concatItems from "../global/concatItems.js";

const path = location.pathname.split('/');

export async function getConsultasSegurosMes({ seguro = "", anio = "", mes = "" } = {}) {


    const nombreSeguro = document.getElementById("nombreSeguro");
    const rifSeguro = document.getElementById("rifSeguro");
    const telSeguro = document.getElementById("telSeguro");
    const direcSeguro = document.getElementById("direcSeguro");
    const porcentajeSeguro = document.getElementById("porcentajeSeguro");
    const costoSeguro = document.getElementById("costoConsultaSeguro");
    const precioExamanes = document.getElementById("precioExamanes");
    const seguroPrecioInput = document.getElementById("seguro_precio_id");
    const btnDelete = document.getElementById("btn-confirmDeleteSeguro");
    const infoSeguro = await getById("seguros", seguro);

    nombreSeguro.textContent = infoSeguro.nombre;
    rifSeguro.textContent = infoSeguro.rif;
    telSeguro.textContent = infoSeguro.telefono;
    direcSeguro.textContent = infoSeguro.direccion;
    porcentajeSeguro.textContent = infoSeguro.porcentaje;
    costoSeguro.textContent = infoSeguro.costo_consulta;
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

    // Si el seguro tiene precio de exámenes lo mostramos, de lo contrario mostramos una alerta de que no posee
    if(examenesList !== ""){
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
    const btnCintillo  = document.getElementById("btn-cintillo-pdf");


    if (listConsultas) {

        idRecibo.textContent = listConsultas.factura[0].factura_seguro_id;
        mesRecibo.textContent = listConsultas.factura[0].mes;
        fechaOcurrencia.textContent = listConsultas.factura[0].fecha_ocurrencia.split(" ")[0];
        fechaVencimiento.textContent = listConsultas.factura[0].fecha_vencimiento;
        montoTotal.textContent = listConsultas.factura[0].monto_usd;

        // Si hay consultas disponibles mostrar el boton del pdf
        if(listConsultas.consultas?.length > 0){
            btnCintillo.setAttribute("onclick",`openPopup('pdf/cintillo/${seguro}-${anio}-${mes}')`)
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

    let consultaSeguro = $('#consultaSeguro').DataTable({

        bAutoWidth: false,
        paging: false,
        info: false,
        scrollX: true,
        scrollY: 350,
        scrollCollapse: true,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        data: listConsultas.consultas ?? [],
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "paciente_titular.cedula" },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.especialidad && data.especialidad.nombre) {
                        return data.especialidad.nombre;
                    } else {
                        return 'Desconocido';
                    }
                }
            },
            { data: "tipo_servicio" },
            { data: "fecha_ocurrencia" },
            { data: "monto_consulta_usd" },
            // {
            //     data: "factura_seguro_id",
            //     render: function (data, type, row) {
            //         // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
            //         if (row.estatus_con == 1) {
            //             return `
            //                 <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFSeguro(${data})"><i class="fas fa-trash del-consulta"></i></a>
            //             `
            //         } else {
            //             return `-`;
            //         }
            //     }
            // }

        ],
        // ! Alinear con text-end los montos
        columnDefs: [
            {
                targets: 5,
                createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
                    // Añadir una clase al td
                    $(cell).addClass('text-end');
                }
            }
        ],
        order: [[4, 'desc']],
        // ! Ocultar los paneles por defecto 
        // columnDefs: [{
        //     searchPanes: {
        //         show: false,
        //     },
        //     targets: [0, 1, 2, 3, 4, 5, 6, 7],
        // }],
        // ! rowData (Devuelve toda la fila)
        // searchPanes: {
        //     controls: false,
        //     hideCount: true,
        //     collapse: true,
        //     initCollapsed: true,
        //     panes: [
        //         {
        //             header: 'Filtrar por estatus de la consulta:',
        //             options: [
        //                 {
        //                     label: 'Pagada',
        //                     value: function (rowData, rowIdx) {
        //                         console.log(rowData.estatus_con);
        //                         return rowData.estatus_con == "1";
        //                     },
        //                     className: 'consulta-pagada'
        //                 },
        //                 {
        //                     label: 'Anulada',
        //                     value: function (rowData, rowIdx) {
        //                         return rowData.estatus_con == "2";
        //                     },
        //                     className: 'consulta-anulada'
        //                 },
        //             ],
        //             dtOpts: {
        //                 searching: false,
        //                 order: [[1, 'desc']]
        //             }
        //         }
        //     ]
        // },
        // dom: 'Plfrtip'
    });

    function format(data) {

        const info = {};

        if (data !== undefined) {

            info.data = data;

            if (data.clave == null) data.clave = "No aplica";
            info.tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";

            info.examenes = data.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen";
            info.insumos = data.insumos !== undefined ? concatItems(data.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo";
            console.log(info.insumos);
            info.indicaciones = data.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";

            info.recipes = `
            <tr>
                <td colspan="4">Recipes:</td>
            </tr>
            `;
            info.factura = "";

            if (data.recipes) {

                data.recipes.forEach(el => {

                    let tipo_medicamento = "";

                    if (el.tipo_medicamento == 1) {
                        tipo_medicamento = "Cápsula";
                    } else if (el.tipo_medicamento == 2) {
                        tipo_medicamento = "Jarabe";
                    } else if (el.tipo_medicamento == 3) {
                        tipo_medicamento = "Inyección";
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
                info.recipes += `
                <tr>
                    <td colspan="4"><b>No hay recipes asigandos</b></td>
                </tr>
                `;
            }

            // <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
            //         <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
            //         <td colspan"2">Uso: <br><b>${el.uso}</b></td>

            if (data.consulta_emergencia) {

                info.factura = `
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="4"><b>Factura consulta emergencia:</b></td>
                </tr>
                `;
                console.log(data);
                info.factura += `
                <tr>
                    <td>Cantidad de consultas médicas: <br><b>${data.consulta_emergencia.cantidad_consultas_medicas}</b></td>
                    <td>Consultas médicas: <br><b>${data.consulta_emergencia.consultas_medicas}</b></td>
                    <td>Cantidad laboratorio: <br><b>${data.consulta_emergencia.cantidad_laboratorios}</b></td>
                    <td>Laboratorios: <br><b>${data.consulta_emergencia.laboratorios}</b></td>
                </tr>
                <tr>
                    <td>Cantidad de medicamentos: <br><b>${data.consulta_emergencia.cantidad_medicamentos}</b></td>
                    <td>Medicamentos: <br><b>${data.consulta_emergencia.medicamentos}</b></td>
                    <td>Area de observación: <br><b>${data.consulta_emergencia.area_observacion}</b></td>
                    <td>Enfermería: <br><b>${data.consulta_emergencia.enfermeria}</b></td>
                </tr>
                <tr>
                    <td>Total insumos: <br><b>${data.consulta_emergencia.total_insumos}</b></td>
                    <td>Total exámenes: <br><b>${data.consulta_emergencia.total_examenes}</b></td>
                    <td>Total consulta: <br><b>${data.consulta_emergencia.total_consulta}</b></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="4"><b>Monto en bs:</b></td>
                </tr>
                <tr>
                    <td>Consultas médicas: <br><b>${data.consulta_emergencia.consultas_medicas_bs} Bs</b></td>
                    <td>Laboratorios: <br><b>${data.consulta_emergencia.laboratorios_bs} Bs</b></td>
                </tr>
                <tr>
                    <td>Medicamentos: <br><b>${data.consulta_emergencia.medicamentos_bs} Bs</b></td>
                    <td>Area de observación: <br><b>${data.consulta_emergencia.area_observacion_bs} Bs</b></td>
                    <td>Enfermería: <br><b>${data.consulta_emergencia.enfermeria_bs} Bs</b></td>
                </tr>
                <tr>
                    <td>Total insumos: <br><b>${data.consulta_emergencia.total_insumos_bs} Bs</b></td>
                    <td>Total exámenes: <br><b>${data.consulta_emergencia.total_examenes_bs} Bs</b></td>
                    <td>Total consulta: <br><b>${data.consulta_emergencia.total_consulta_bs} Bs</b></td>
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
                    <td>Fecha de nacimiento: <br><b>${data.paciente_beneficiado.fecha_nacimiento}</b></td>
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
                    <td>Cédula: <br><b>${data.medico.cedula}</b></td>
                    <td>Nombres: <br><b>${data.medico.nombre}</b></td>
                    <td>Apellidos: <br><b>${data.medico.apellidos}</b></td>
                </tr>
                <tr>
                    <td>Especialidad: <br><b>${data?.especialidad.nombre ?? "Desconocida"}</b></td>
                </tr>

                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
            `;
            }
        }

        console.log(info);


        return `
        <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
            <tr>
                <td colspan="4"><b>Información consulta:</b></td>
            </tr>
            <tr>
                <td>Peso: <br><b>${info.data?.consulta.peso}</b></td>
                <td>Altura: <br><b>${info.data?.consulta.altura}</b></td>
                <td>Fecha Cita: <br><b>${info.data?.cita?.fecha_cita ?? "No aplica"}</b></td>
                <td>Motivo cita: <br><b>${info.data?.cita?.motivo_cita ?? "No aplica"}</b></td>
            </tr>
            <tr class="blue-td">
                <td>Clave: <br><b>${info.data?.cita?.clave}</b></td>
                <td>Exámenes realizados: <br><b>${info?.examenes}</b></td>
                <td>Insumos utilizados: <br><b>${info?.insumos}</b></td>
            </tr>
            ${info.paciente_beneficiado}
            ${info.medico}
            ${info.factura}
            <tr><td><br></td></tr>
            <tr>
                <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/consultaemergencia/${info.data?.consulta_seguro_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
            </tr>
        </table>
    `

    }

    // if (info && info.data && info.data.cita) {
    //      fecha_cita = info.data.cita.fecha_cita;
    //   } else {
    //      fecha_cita = 'valor predeterminado';
    //   }






    $('#consultaSeguro').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = consultaSeguro.row(tr);

        if (row.child.isShown()) {

            row.child.hide();
            tr.removeClass('shown');
        }
        else {

            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
}

addEventListener("DOMContentLoaded", async e => {

    const urlParams = new URLSearchParams(window.location.search);
    const seguro_id = urlParams.get('seguro');

    const btnActualizar = document.getElementById("btn-actualizar");

    btnActualizar.setAttribute("onclick", `updateSeguro(${seguro_id})`);

    getConsultasSegurosMes({ seguro: seguro_id });
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


