import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');


addEventListener("DOMContentLoaded", e => {

    let fConsulta = $('#fConsulta').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/factura/consulta/consulta/`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function(xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);
                
                $('#fConsulta').DataTable().clear().draw();
            }
        },
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {
                data: function (row) {
                    return `${row.nombre_paciente} ${row.apellidos}` ?? `Consulta por emergercia`;
                }
            },
            {
                data: function (row) {
                    return row.metodo_pago;
                }
            },
            {
                data: function (row) {
                    return row.monto_total_usd;
                }
            },
            {
                data: function (row) {
                    return row.monto_total_bs;
                }
            },
            {
                data: function (row) {
                    return row.fecha_consulta;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (row.estatus_fac == 1) {
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else {
                        return `<span class="badge light badge-danger">Anulada</span>`;
                    }
                },
            },
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
            //         if (row.estatus_fac == 1) {
            //             return `
            //                 <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFConsulta(${row.estatus_fac})"><i class="fas fa-trash del-consulta"></i></a>
            //             `
            //         } else {
            //             return `-`;
            //         }
            //     }
            // }

        ],
        order: [[5, 'desc']],
        // ! Ocultar los paneles por defecto 
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5],
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

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td colspan="4"><b>Información consulta:</b></td>
                </tr>
                <tr>
                    <td>Nombre médico: <br><b>${data?.nombre_medico ? data?.nombre_medico + " " + data?.apellidos_medico : "Desconocido"}</b></td>
                    <td>Especialidad: <br><b>${data?.nombre_especialidad ?? "Desconocido"}</b></td>
                    <td>Monto consulta BS: <br><b>${data?.monto_consulta_bs ?? "Desconocido"}</b></td>
                    <td>Monto consulta USD: <br><b>${data?.monto_consulta_usd ?? "Desconocido"}</b></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturaconsulta/${data.factura_consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
                </tr>
            </table>
        `;
    }

    $('#fConsulta').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = fConsulta.row(tr);

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


