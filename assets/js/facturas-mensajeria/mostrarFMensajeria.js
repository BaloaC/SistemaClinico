import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import createDataTable from "../global/createDataTable.js";
import formatToRealDate from "../global/formatToRealDate.js";
import { removeAddAccountant } from "../global/validateRol.js";

const path = location.pathname.split('/');


addEventListener("DOMContentLoaded", e => {

    // Eliminar el botón de añadir según el rol
    removeAddAccountant();

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const fMensajeriaColumns = [
        {
            "className": 'dt-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        { data: "factura_mensajeria_id" },
        {
            data: function (row) {
                return row?.consultas[0]?.rif_seguro ?? "Desconocido";
            }
        },
        {
            data: function (row) {
                return row?.consultas[0]?.nombre_seguro ?? "Desconocido";
            }
        },
        {
            data: "fecha_mensajeria",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
        {
            data: "total_mensajeria_usd",
            render: function (data, row, type) {
                return `$${data}`;
            }
        },
        {
            data: "total_mensajeria_bs",
            render: function (data, row, type) {
                return `${convertCurrencyToVES(data)} Bs`
            }
        },
        {
            data: "factura_mensajeria_id",
            render: function (data, row, type) {
                return `<a href="#" onclick="openPopup('pdf/facturamensajeria/${data}')"><i class="fas fa-file-export"></i></a>`;
            }
        }
    ];

    const columnDefsFMensajeria = [
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5],
        },
        // Para permitir el filtrado con la fecha filtrada
        {
            type: 'datetime-moment',
            targets: 3
        },
    ];
    const order = [[3, 'desc']];

    const format = (data) => {
        console.log(data);
        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td><p class="link-primary cursor-pointer" onclick="openPopupDatelleFactura('${data.factura_mensajeria_id}')">Visualizar consultas del recibo</p></td>
                </tr>
            </table>
        `;
    }

    createDataTable({
        id: "#fMensajeria",
        url: `/${path[1]}/factura/mensajeria/consulta/`,
        columns: fMensajeriaColumns,
        columnDefs: columnDefsFMensajeria,
        order,
        format,
        processing: true,
        serverSide: true
    });
});