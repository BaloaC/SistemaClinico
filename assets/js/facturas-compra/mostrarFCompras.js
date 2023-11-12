import dinamicSelect2, {
    emptySelect2,
    select2OnClick,
} from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split("/");

select2OnClick({
    selectSelector: "#s-proveedor",
    selectValue: "proveedor_id",
    selectNames: ["proveedor_id", "nombre"],
    module: "proveedores/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un proveedor",
    selectWidth: "100%",
});

select2OnClick({
    selectSelector: "#s-insumo",
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    module: "insumos/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione el insumo",
    selectWidth: "100%",
});

addEventListener("DOMContentLoaded", (e) => {
    let fCompra = $("#fCompra").DataTable({
        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`,
        },
        ajax: { 
            url: `/${path[1]}/factura/compra/consulta/`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function(xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);
            }
        },
        columns: [
            {
                className: "dt-control",
                orderable: false,
                data: null,
                defaultContent: "",
            },
            { data: "proveedor_nombre" },
            {
                data: "insummos",
                render: function (data) {
                    let totalInsumos = 0;
                    data.forEach((insumos) => (totalInsumos += insumos.unidades));
                    return totalInsumos;
                },
            },
            { data: "monto_con_iva" },
            { data: "monto_sin_iva" },
            {
                data: "excento",
                render: function (data, type, row) {
                    return data === null ? "Ninguno" : data;
                },
            },
            { data: "fecha_compra" },
            {
                data: "estatus_fac",
                render: function (data, type, row) {
                    if(data == 1){
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else{
                        return `<span class="badge light badge-danger">Anulada</span>`;
                    }
                },
            },
            {
                data: "factura_compra_id",
                render: function (data, type, row) {
                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    if(row.estatus_fac == 1){
                        return `
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFCompra(${data})"><i class="fas fa-trash del-consulta"></i></a>
                        `;
                    } else{
                        return `-`;
                    }
                },
            },
        ],
        order: [[7, 'desc'], [6, 'desc']],
        // ! Ocultar los paneles por defecto
        columnDefs: [
            {
                searchPanes: {
                    show: false,
                },
                targets: [0, 1, 2, 3, 4, 5, 6, 7],
            },
        ],
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
                },
            ]
        },
        dom: "Plfrtip",
    });

    function format(data) {
        console.log(data);
        let template = `<table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">`;
        data.insummos.forEach((e) => {
            template += `
                <tr>
                    <td>Nombre Insumo: ${e.insumo_nombre}</td>
                    <td>Unidades: ${e.unidades}</td>
                    <td>Precio unitario: ${e.precio_unit_bs}</td>
                    <td>Precio total: ${e.precio_total_bs}</td>
                </tr>
            `;
        });
        template += `<tr>
            <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturacompra/${data.factura_compra_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
        </tr>`;
        template += `</table>`;
        return template;
    }

    $("#fCompra").on("click", "td.dt-control", function () {
        let tr = $(this).closest("tr");
        let row = fCompra.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass("shown");
        } else {
            row.child(format(row.data())).show();
            tr.addClass("shown");
        }
    });
});
