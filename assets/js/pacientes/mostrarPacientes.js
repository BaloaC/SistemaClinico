import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
removeAddAccountant();
removeAddAnalist();
const path = location.pathname.split('/');

select2OnClick({
    selectSelector: "#s-seguro",
    selectValue: "seguro_id",
    selectNames: ["rif", "nombre"],
    module: "seguros/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un seguro",
    multiple: true
});

select2OnClick({
    selectSelector: "#s-empresa",
    selectValue: "empresa_id",
    selectNames: ["rif", "nombre"],
    module: "empresas/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione una empresa"
});

// dinamicSelect2({
//     obj: [{ id: 1, text: "Natural" }, { id: 2, text: "Asegurado" }, { id: 3, text: "Beneficiado" }],
//     selectNames: ["text"],
//     selectValue: "id",
//     selectSelector: "#s-tipo_paciente",
//     placeholder: "Seleccione el tipo de paciente",
//     parentModal: "#modalReg",
//     staticSelect: true
// });

dinamicSelect2({
    obj: [{ id: 1, text: "Acumulativo" }, { id: 2, text: "Normal" }],
    selectNames: ["text"],
    selectValue: "id",
    selectSelector: "#s-tipo_seguro",
    placeholder: "Seleccione el tipo de seguro",
    parentModal: "#modalReg",
    staticSelect: true
});

addEventListener("DOMContentLoaded", e => {

    let pacientes = $('#pacientes').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/pacientes/consulta/`,
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "cedula" },

            // ! Nombre paciente (asegurado y natural)
            {
                "data": function (row, type, val, meta) {

                    if (row.nombre) {
                        return row.nombre;

                    } else {
                        return row.nombre_paciente;
                    }
                }
            },
            { data: "apellidos" },
            { data: "edad" },
            {
                data: "tipo_paciente",
                render: function (data, type, row) {

                    switch (data) {
                        case '1': return 'Natural';
                        case '2': return 'Representante';
                        case '3': return 'Asegurado';
                        case '4': return 'Beneficiado'
                        default: return 'Natural';
                    }
                }
            },
            {
                data: "paciente_id",
                render: function (data, type, row) {

                    return `
                    <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a> --> 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-paciente" onclick="updatePaciente(${data})"><i class="fas fa-edit act-paciente"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deletePaciente(${data})"><i class="fas fa-trash del-paciente"></i></a>
                    `
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
            panes: [
                {
                    header: 'Filtrar por tipo de paciente:',
                    options: [
                        {
                            label: 'Paciente natural',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "1";
                            },
                            className: 'paciente-natural'
                        },
                        {
                            label: 'Paciente asegurado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "2";
                            },
                            className: 'paciente-asegurado'
                        },
                        {
                            label: 'Paciente beneficiado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "3";
                            },
                            className: 'paciente-beneficiado'
                        }
                    ],
                    dtOpts: {
                        searching: false,
                        order: [[1, 'desc']]
                    }
                },
                {
                    header: 'Filtrar por edad:',
                    options: [
                        {
                            label: 'Menores de 18 años',
                            value: function (rowData, rowIdx) {
                                return rowData.edad < 18;
                            },
                            className: 'may-18'
                        },
                        {
                            label: 'Mayores de 18 años',
                            value: function (rowData, rowIdx) {
                                return rowData.edad > 18;
                            },
                            className: 'men-18'
                        }
                    ],
                }
            ]
        },
        dom: 'Plfrtip'
    });

    function format(data) {

        console.log(data);
        if (!data.nombre_seguro) data.nombre_seguro = "No aplica";
        if (!data.saldo_disponible) data.saldo_disponible = "No aplica";

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Fecha de Nacimiento: <b>${data.fecha_nacimiento}</b></td>
                    <td>Teléfono: <b>${data.telefono}</b></td>
                    <td>Dirección: <b>${data.direccion}</b></td>
                </tr>
            </table>
        `
    }

    $('#pacientes').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = pacientes.row(tr);

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


