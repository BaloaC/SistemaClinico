import getById from "../global/getById.js";
import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";


const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", async e => {

    const id = location.pathname.split("/")[4].split("-");

    // Pasamos la info del seguro para poder actualizar
    document.getElementById("btn-actualizar").setAttribute("onclick", `actualizarFSeguro('${location.pathname.split("/")[4]}')`);

    let listadoFacturas = await getById("factura/seguro", id[0]);

    // Filtramos las facturas por el año que se consulta
    listadoFacturas = listadoFacturas.filter(factura => factura.fecha_ocurrencia.slice(0, 4) === id[1]);

    const fSeguroColumns = [
        {
            "className": 'dt-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        { data: "rif" },
        { data: "nombre" },
        { data: "mes" },
        {
            data: "fecha_ocurrencia",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
        {
            data: "fecha_vencimiento",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
        {
            data: "monto_usd",
            render: function (data, type, row) {
                return `$${data}`
            }
        },
        {
            data: "monto_bs",
            render: function (data, type, row) {
                return `${convertCurrencyToVES(data)} Bs`
            }
        },
        {
            data: "fecha_vencimiento",
            render: function (data, type, row) {

                const fechaActual = luxon.DateTime.local();
                const fechaVencimiento = luxon.DateTime.fromISO(data);
                const diasRestantes = Math.round(fechaVencimiento.diff(fechaActual, 'days').toObject().days) + 1;

                // Si la factura está pagada o anulada rellenar este campo de fecha con dicho estatus
                if (row.estatus_fac == 3) {
                    return `<span class="badge light badge-success">Pagada</span>`;
                } else if (row.estatus_fac == 2) {
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
                if (row.estatus_fac == 3) {
                    return `<span class="badge light badge-success">Pagada</span>`;
                } else if (row.estatus_fac == 2) {
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
                } else if (data == 2) {
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

    ];

    const dataFSeguro = listadoFacturas ?? [];
    const order = [[7, 'desc'], [4, 'desc']];

    const searchPanesFSeguro = {
        controls: false,
        hideCount: true,
        collapse: true,
        initCollapsed: true,
        panes: [
            {
                header: 'Filtrar por estatus del recibo:',
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
    };

    const columnDefsFSeguro = [{
        searchPanes: {
            show: false,
        },
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
    }];

    const format = (data) => {
        console.log(data);
        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                <td><a href="../../factura/consultaSeguro?seguro=${data.seguro_id}&mes=${new Date(data.fecha_ocurrencia).getMonth() + 1}&anio=${new Date(data.fecha_ocurrencia).getFullYear()}">Visualizar consultas de las facturas</a></td>
                    <td>Datos consulta: ${data.factura_seguro_id}</td>
                </tr>
            </table>
        `;
    }

    createDataTable({
        id: "#fSeguros",
        data: dataFSeguro,
        columns: fSeguroColumns,
        order,
        format,
        columnDefs: columnDefsFSeguro,
        searchPanes: searchPanesFSeguro,
        dom: "Plfrtip"
    });
});