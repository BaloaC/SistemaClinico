import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');

select2OnClick({
    selectSelector: "#s-medico",
    selectValue: "medico_id",
    selectNames: ["cedula", "nombre-apellidos"],
    module: "medicos/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un médico",
    selectWidth: "100%"
});

addEventListener("DOMContentLoaded", e => {

    let fMedicos = $('#fMedicos').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/factura/medico/consulta/`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            }
        },
        columns: [
            { data: "nombre" },
            { data: "acumulado_seguro_total" },
            { data: "acumulado_consulta_total" },
            { data: "fecha_pago" },
            { data: "pago_total" },
            {
                data: "factura_medico_id",
                render: function (data, type, row) {

                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    return `
                        <a href="#" onclick="openPopup('pdf/facturamedico/${data}')"><i class="fas fa-file-export"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFMedico(${data})"><i class="fas fa-trash del-consulta"></i></a>
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
});


