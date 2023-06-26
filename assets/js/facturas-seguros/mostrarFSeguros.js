import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";

const path = location.pathname.split('/');

// select2OnClick({
//     selectSelector: "#s-consulta",
//     selectValue: "consulta_id",
//     selectNames: ["consulta_id", "motivo_cita"],
//     module: "consultas/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione una consulta",
//     selectWidth: "100%"
// });

// dinamicSelect2({
//     obj: [{ id: "consulta", text: "Consulta" }, { id: "laboratorio", text: "Laboratorio" }],
//     selectNames: ["text"],
//     selectValue: "id",
//     selectSelector: "#s-tipo-servicio",
//     placeholder: "Seleccione un tipo de servicio",
//     parentModal: "#modalReg",
//     staticSelect: true,
//     selectWidth: "100%"
// });

addEventListener("DOMContentLoaded", async e => {

    const id = location.pathname.split("/")[4].split("-");
    let listadoFacturas = await getById("factura/seguro", id[0]);

    // Filtramos las facturas por el año que se consulta
    listadoFacturas = listadoFacturas.filter(factura => factura.fecha_ocurrencia.slice(0, 4) === id[1]);

    console.log(listadoFacturas);

    let fSeguros = $('#fSeguros').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        data: listadoFacturas,
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "rif" },
            { data: "nombre" },
            { data: "mes" },
            { data: "fecha_ocurrencia" },
            { data: "fecha_vencimiento" },
            { data: "monto" },
            {
                data: "fecha_vencimiento",
                render: function (data, type, row) {

                    const fechaActual = luxon.DateTime.local();
                    const fechaVencimiento = luxon.DateTime.fromISO(data);
                    const diasRestantes = Math.round(fechaVencimiento.diff(fechaActual, 'days').toObject().days) + 1;

                    // Si la factura está pagada o anulada rellenar este campo de fecha con dicho estatus
                    if(row.estatus_fac == 3){
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else if(row.estatus_fac == 2){
                        return `<span class="badge light badge-danger">Anulada</span>`
                    }

                    return diasRestantes < 0 ? `<span class="badge light badge-danger">Vencida</span>` : diasRestantes;
                }

            },
            {
                data: "fecha_vencimiento",
                render: function (data, type, row) {

                    const fechaActual = luxon.DateTime.local();
                    const fechaVencimiento = luxon.DateTime.fromISO(data);
                    const diasRestantes = Math.round(fechaVencimiento.diff(fechaActual, 'days').toObject().days) + 1;

                    // Si la factura está pagada o anulada rellenar este campo de fecha con dicho estatus
                    if(row.estatus_fac == 3){
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else if(row.estatus_fac == 2){
                        return `<span class="badge light badge-danger">Anulada</span>`
                    }

                    return diasRestantes < 0 ? Math.abs(diasRestantes) : `<span class="badge light badge-success">Vigente</span>`;
                }

            },
            {
                data: "estatus_fac",
                render: function (data, type, row) {
                    if (data == 3) {
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else if (data == 1) {
                        return `<span class="badge light badge-warning">Pendiente</span>`;
                    } else if(data == 2) {
                        return `<span class="badge light badge-danger">Anulada</span>`;
                    } else {
                        return `<span class="badge light badge-warning">Pendiente</span>`;
                    }
                },
            }, 
            {
                data: "factura_seguro_id",
                render: function (data, type, row) {
                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    if (row.estatus_fac == 1) {
                        return `
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFSeguro(${data})"><i class="fas fa-trash del-consulta"></i></a>
                        `
                    } else {
                        return `-`;
                    }
                }
            }

        ],
        order: [[7, 'desc'], [4, 'desc']],
        // ! Ocultar los paneles por defecto 
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5, 6, 7],
        }],
        // ! rowData (Devuelve toda la fila)
        searchPanes: {
            controls: false,
            hideCount: true,
            collapse: true,
            initCollapsed: true,
            panes: [
                {
                    header: 'Filtrar por estatus de la factura:',
                    options: [
                        {
                            label: 'Pagada',
                            value: function (rowData, rowIdx) {
                                return rowData.estatus_fac === "1";
                            },
                            className: 'factura-pagada'
                        },
                        {
                            label: 'Anulada',
                            value: function (rowData, rowIdx) {
                                return rowData.estatus_fac === "2";
                            },
                            className: 'factura-anulada'
                        },
                    ],
                    dtOpts: {
                        searching: false,
                        order: [[1, 'desc']]
                    }
                }
            ]
        },
        dom: 'Plfrtip'
    });

    function format(data) {

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Datos consulta: ${data.factura_seguro_id}</td>
                </tr>
            </table>
        `;
    }

    $('#fSeguros').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = fSeguros.row(tr);

        if (row.child.isShown()) {

            row.child.hide();
            tr.removeClass('shown');
        }
        else {

            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});


