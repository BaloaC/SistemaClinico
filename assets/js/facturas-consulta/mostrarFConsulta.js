import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";

const path = location.pathname.split('/');

select2OnClick({
    selectSelector: "#s-paciente",
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    module: "pacientes/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un paciente"
});

select2OnClick({
    selectSelector: "#s-consulta",
    selectValue: "consulta_id",
    selectNames: ["consulta_id", "motivo_cita"],
    module: "consultas/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione una consulta"
});

dinamicSelect2({
    obj: [{ id: "efectivo", text: "Efectivo" }, { id: "debito", text: "Debito" }],
    selectNames: ["text"],
    selectValue: "id",
    selectSelector: "#s-metodo-pago",
    placeholder: "Seleccione un método de pago",
    parentModal: "#modalReg",
    staticSelect: true
});

function calcularIva(montoInput) {

    let montoTotal = (parseFloat(montoInput.value) * 0.16) + parseFloat(montoInput.value);
    document.getElementById("monto_con_iva").value = montoTotal.toFixed(2);
}

window.calcularIva = calcularIva;


addEventListener("DOMContentLoaded", e => {

    let fConsulta = $('#fConsulta').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/factura/consulta/consulta/`,
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "paciente_id" },
            { data: "metodo_pago" },
            { data: "monto_sin_iva" },
            { data: "monto_con_iva" },
            {
                data: "estatus_fac",
                render: function (data, type, row) {
                    if (data == 1) {
                        return `<span class="badge light badge-success">Pagada</span>`;
                    } else {
                        return `<span class="badge light badge-danger">Anulada</span>`;
                    }
                },
            },
            {
                data: "factura_consulta_id",
                render: function (data, type, row) {
                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    if (row.estatus_fac == 1) {
                        return `
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFConsulta(${data})"><i class="fas fa-trash del-consulta"></i></a>
                        `
                    } else {
                        return `
                            <a class="del-paciente"><i class="fas fa-trash disabled del-consulta"></i></a>
                        `;
                    }
                }
            }

        ],
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
                    <td>Datos consulta:</td>
                    <td>${data.consulta_id}</td>
                </tr>
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


