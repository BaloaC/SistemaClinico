import dinamicSelect2 from "../global/dinamicSelect2.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

dinamicSelect2({
    selectSelector: "#s-medico",
    selectValue: "medico_id",
    selectNames: ["cedula", "nombre-apellidos"],
    parentModal: "#modalReg",
    placeholder: "Seleccione un médico",
    selectWidth: "100%",
    ajax: true,
    ajaxUrl: "medicos/consulta",
    processResultsAjax: function (data, params) {

        params.page = params.page || 1;

        const data1 = data?.data.map(object => {
            const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico } = object;
            return { id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` };
        });

        // Transforms the top-level key of the response object from 'data' to 'results'
        return {
            results: data1,
            pagination: {
                more: data1.length
            }
        };
    }
});

addEventListener("DOMContentLoaded", e => {

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const fMedicosColumns = [
        { data: "factura_medico_id" },
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

    const order = [[6, 'desc']];

    createDataTable({
        id: "#fMedicos",
        url: `/${path[1]}/factura/medico/consulta/`,
        columns: fMedicosColumns,
        order,
        processing: true,
        serverSide: true
    })

});
