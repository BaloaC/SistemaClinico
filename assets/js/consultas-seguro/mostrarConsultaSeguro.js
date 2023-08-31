import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

const path = location.pathname.split('/');

async function getConsultasSegurosMes({ seguro = "", anio = "", mes = "" } = {}) {


    const nombreSeguro = document.getElementById("nombreSeguro");
    const rifSeguro = document.getElementById("rifSeguro");
    const telSeguro = document.getElementById("telSeguro");
    const direcSeguro = document.getElementById("direcSeguro");
    const porcentajeSeguro = document.getElementById("porcentajeSeguro");
    const costoSeguro = document.getElementById("costoConsultaSeguro");
    const infoSeguro = await getById("seguros", seguro);

    nombreSeguro.textContent = infoSeguro.nombre;
    rifSeguro.textContent = infoSeguro.rif;
    telSeguro.textContent = infoSeguro.telefono;
    direcSeguro.textContent = infoSeguro.direccion;
    porcentajeSeguro.textContent = infoSeguro.porcentaje;
    costoSeguro.textContent = infoSeguro.costo_consulta;
    
    // Ocultar datos de la factura antes de la petición
    $(".factura-header").fadeOut("slow");
    $(".total-amount").fadeOut("slow");


    let listConsultas = await getAll(`factura/seguro/consultaseguro?seguro=${seguro}&anio=${anio}&mes=${mes}`);

    // Datos facturas
    const montoTotal = document.getElementById("total-price");
    const idRecibo = document.getElementById("factura_id");
    const mesRecibo = document.getElementById("mes-factura");
    const fechaOcurrencia = document.getElementById("fecha-ocurrencia");
    const fechaVencimiento = document.getElementById("fecha-vencimiento");
    const estatusFactura = document.getElementById("factura-estatus");


    if (listConsultas) {

        idRecibo.textContent = listConsultas.factura[0].factura_seguro_id;
        mesRecibo.textContent = listConsultas.factura[0].mes;
        fechaOcurrencia.textContent = listConsultas.factura[0].fecha_ocurrencia.split(" ")[0];
        fechaVencimiento.textContent = listConsultas.factura[0].fecha_vencimiento;
        montoTotal.textContent = listConsultas.factura[0].monto;
        
        // Si la factura está pagada o pendiente rellenar este campo de fecha con dicho estatus
        if(listConsultas.factura[0].estatus_fac == 1){
            estatusFactura.innerHTML = '<span class="badge light badge-warning">Pendiente</span>';
        } else{
            estatusFactura.innerHTML = '<span class="badge light badge-success">Pagada</span>';
        }

        $(".factura-header").fadeIn("slow");
        $(".card-body").fadeIn("slow");
        $(".total-amount").fadeIn("slow");

        window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);

    } else {
        listConsultas = [];
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
            { data: "monto" },
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

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Datos consulta: a</td>
                </tr>
            </table>
        `;
    }


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
    const btnEliminar = document.getElementById("btn-confirmDelete");

    btnActualizar.setAttribute("onclick", `updateSeguro(${seguro_id})`);
    btnEliminar.setAttribute("onclick", `deleteSeguro(${seguro_id})`);

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


