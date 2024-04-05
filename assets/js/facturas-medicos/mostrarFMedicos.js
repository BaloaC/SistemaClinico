import { select2OnClick } from "../global/dinamicSelect2.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";

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

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const fMedicosColumns = [
        {
            data: "nombre",
            render: function (data, type, row) {
                return `${row.nombre} ${row.apellidos}`;
            }
        },
        { data: "sumatoria_consultas_aseguradas" },
        { data: "sumatoria_consultas_naturales" },
        {
            data: "acumulado_seguro_total",
            render: function (data, type, row) {
                return `$${data}`;
            }
        },
        {
            data: "acumulado_consulta_total",
            render: function (data, type, row) {
                return `$${data}`;
            }
        },
        {
            data: "fecha_pago",
            render: function (data, type, row) {
                console.log(row);
                return formatToRealDate(data);
            },
        },
        {
            data: "fecha_emision",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
        {
            data: "pago_total", render: function (data, type, row) {
                return `$${data}`;
            }
        },
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

    ];

    const columnDefsFMedico = [
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5, 6, 7],
        },
        // Para permitir el filtrado con la fecha filtrada
        {
            type: 'datetime-moment',
            targets: 7
        },
    ];

    const searchPanesFMedico = {
        controls: false,
        hideCount: true,
        collapse: true,
        initCollapsed: true
    };

    const order = [[6, 'desc']];

    createDataTable({
        id: "#fMedicos",
        url: `/${path[1]}/factura/medico/consulta/`,
        columns: fMedicosColumns,
        // columnDefs: columnDefsFMedico,
        // searchPanes: searchPanesFMedico,
        order,
        // dom: "Plfrtip",
        processing: true,
        serverSide: true
    })

});
