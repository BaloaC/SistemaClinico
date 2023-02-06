import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";

const path = location.pathname.split('/');

select2OnClick({
    selectSelector: "#s-proveedor",
    selectValue: "proveedor_id",
    selectNames: ["proveedor_id", "nombre"],
    module: "proveedores/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un proveedor"
});

select2OnClick({
    selectSelector: "#s-insumo",
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    module: "insumos/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione el insumo"
});



addEventListener("DOMContentLoaded", e => {

    let fCompra = $('#fCompra').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/factura/compra/consulta/`,
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "proveedor_nombre" },
            {
                data: "insummos",
                render: function (data) {
                    let totalInsumos = 0;
                    data.forEach(insumos => totalInsumos += insumos.unidades);
                    return totalInsumos;
                }
            },
            { data: "monto_con_iva" },
            { data: "monto_sin_iva" },
            {
                data: "excento",
                render: function (data, type, row) {
                    return (data === null) ? "Ninguno" : data;
                }
            },
            { data: "fecha_compra" },
            {
                data: "factura_compra_id",
                render: function (data, type, row) {

                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFCompra(${data})"><i class="fas fa-trash del-consulta"></i></a>
                    `
                }
            }

        ],
        // ! Ocultar los paneles por defecto 
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5, 6],
        }],
        // ! rowData (Devuelve toda la fila)
        searchPanes: {
            controls: false,
            hideCount: true,
            collapse: true,
            initCollapsed: true,
            // panes: [
            //     {
            //         header: 'Filtrar por tipo de paciente:',
            //         options: [
            //             {
            //                 label: 'Paciente natural',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.tipo_paciente === "1";
            //                 },
            //                 className: 'paciente-natural'
            //             },
            //             {
            //                 label: 'Paciente asegurado',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.tipo_paciente === "2";
            //                 },
            //                 className: 'paciente-asegurado'
            //             },
            //             {
            //                 label: 'Paciente beneficiado',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.tipo_paciente === "3";
            //                 },
            //                 className: 'paciente-beneficiado'
            //             }
            //         ],
            //         dtOpts: {
            //             searching: false,
            //             order: [[1, 'desc']]
            //         }
            //     },
            //     {
            //         header: 'Filtrar por edad:',
            //         options: [
            //             {
            //                 label: 'Menores de 18 años',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.edad < 18;
            //                 },
            //                 className: 'may-18'
            //             },
            //             {
            //                 label: 'Mayores de 18 años',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.edad > 18;
            //                 },
            //                 className: 'men-18'
            //             }
            //         ],
            //     }
            // ]
        },
        dom: 'Plfrtip'
    });

    function format(data) {

        let template = `<table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">`;
        data.insummos.forEach(e => {
            template += `
                <tr>
                    <td>Peso:</td>
                    <td>${e.insumo_nombre}</td>
                    <td>Unidades:</td>
                    <td>${e.unidades}</td>
                </tr>
                <tr class="blue-td">
                    <td>Precio unitario:</td>
                    <td>${e.precio_unit}</td>
                    <td>Precio total:</td>
                    <td>${e.precio_total}</td>
                </tr>
            `;
        })
        template += `</table>`;
        return template;
    }

    $('#fCompra').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = fCompra.row(tr);

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