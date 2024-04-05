import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getById from "./getById.js";

const path = location.pathname.split('/');

export default function createDataTable({ id, columns, url = null, data = null, columnDefs = null, searchPanes = null, dom = null, format = undefined, formatDataCustom = false, formatDataCustomUrl = null, formatDataCustomId = null, serverSide = false, processing = false, order = null, paging = true, info = true, scrollX = false, scrollY = null, scrollCollapse = false}) {

    const ajax = (url !== null) ? {
        url,
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
        },
        error: function (xhr, error, thrown) {
            // Manejo de errores de Ajax
            console.log('Error de Ajax:', error);
            console.log('Detalles:', thrown);
            console.log(xhr?.responseText);

            $(id).DataTable().clear().draw();
        }
    } : null;

    const config = {

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax,
        data,
        columns,
        // Para ocultar los searchPanes por defecto o establecer a que campo se le corregirá la fecha
        columnDefs,
        // Para aplicar los filtros dentro de los datatables
        searchPanes,
        processing,
        serverSide,
        paging,
        info
    }

    // Se verifican que esas propiedades no estén null para poder ingresarlas a la configuración
    if (dom !== null) config.dom = dom;
    if (order !== null) config.order = order;
    if (scrollY !== null) config.scrollY = scrollY;
    if (scrollX !== null) config.scrollX = scrollX;
    if (scrollCollapse !== null) config.scrollCollapse = scrollCollapse;

    let dataTable = $(id).DataTable(config);

    if (format !== undefined) {
        $(id).on('click', 'td.dt-control', async function () {
            let tr = $(this).closest('tr');
            let row = dataTable.row(tr);

            if (row.child.isShown()) {

                row.child.hide();
                tr.removeClass('shown');
            }
            else {

                let formatData = row.data();

                // Se realiza una petición en caso de ser verdadero, para mostrar el detalle a través de la misma
                if (formatDataCustom === true) {
                    formatData = await getById(formatDataCustomUrl, row.data()[formatDataCustomId]);
                    if(formatData[0]) formatData = formatData[0];
                }

                row.child(format(formatData)).show();
                tr.addClass('shown');
            }
        });
    }


    return dataTable;
}