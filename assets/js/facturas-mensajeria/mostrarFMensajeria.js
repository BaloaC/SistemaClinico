// import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');


addEventListener("DOMContentLoaded", e => {

    let fConsulta = $('#fMensajeria').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/factura/mensajeria/consulta/`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            }
        },
        columns: [
            { data: "factura_mensajeria_id" },
            {
                data: function (row) {
                    return row?.consultas[0].nombre_seguro ?? "Desconocido";
                }
            },
            {
                data: "fecha_mensajeria"
            },
            {
                data: "total_mensajeria_usd"
            },
            {
                data: "total_mensajeria_bs"
            },
            {
                data: "total_mensajeria_bs"
            },
            {
                data: "factura_mensajeria_id",
                render: function (data, row, type) {
                    return `<a href="#" onclick="openPopup('pdf/facturamedico/${data}')"><i class="fas fa-file-export"></i></a>`;
                }
            }
            // {
            //     data: function (row) {
            //         return row[0].monto_total_usd;
            //     }
            // },
            // {
            //     data: function (row) {
            //         return row[0].monto_total_bs;
            //     }
            // },
            // {
            //     data: function (row) {
            //         return row[0].fecha_consulta;
            //     }
            // },
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         // console.log(row[0]);
            //         if (row[0].estatus_fac == 1) {
            //             return `<span class="badge light badge-success">Pagada</span>`;
            //         } else {
            //             return `<span class="badge light badge-danger">Anulada</span>`;
            //         }
            //     },
            // },
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
            //         if (row[0].estatus_fac == 1) {
            //             return `
            //                 <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFConsulta(${row[0].estatus_fac})"><i class="fas fa-trash del-consulta"></i></a>
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
    });

    // function format(data) {

    //     console.log(data);

    //     return `
    //         <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
    //             <tr>
    //                 <td colspan="4"><b>Información consulta:</b></td>
    //             </tr>
    //             <tr>
    //                 <td>Nombre médico: <br><b>${data[0]?.nombre_medico ?? "Desconocido"}</b></td>
    //                 <td>Especialidad: <br><b>${data[0]?.nombre_especialidad ?? "Desconocido"}</b></td>
    //                 <td>Monto consulta BS: <br><b>${data[0]?.monto_consulta_bs ?? "Desconocido"}</b></td>
    //                 <td>Monto consulta USD: <br><b>${data[0]?.monto_consulta_usd ?? "Desconocido"}</b></td>
    //             </tr>
    //             <tr><td><br></td></tr>
    //             <tr>
    //                 <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturaconsulta/${data[0].factura_consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
    //             </tr>
    //         </table>
    //     `;
    // }

    // $('#fConsulta').on('click', 'td.dt-control', function () {
    //     let tr = $(this).closest('tr');
    //     let row = fConsulta.row(tr);

    //     if (row.child.isShown()) {

    //         row.child.hide();
    //         tr.removeClass('shown');
    //     }
    //     else {

    //         row.child(format(row.data())).show();
    //         tr.addClass('shown');
    //     }
    // });
});


