import createDataTable from "../global/createDataTable.js";
import formatToRealDate from "../global/formatToRealDate.js";

const path = location.pathname.split('/');

async function filtrarFacturaMedico(e) {
    e.preventDefault();

    const $form = document.getElementById("filtrarPor");
    const formData = new FormData($form),
        data = {};

    formData.forEach((value, key) => (data[key] = value));

    console.log(data);
    if (!$form.checkValidity()) { $form.reportValidity(); return; }

    let filtroUrl = "";

    if(data.medico_id) filtroUrl += `?medico_id=${data.medico_di}`;
    if(data.fecha_inicio) filtroUrl += `&fecha_inicio=${data.fecha_inicio}&fecha_fin=${data.fecha_fin}`;   

    // Nos aseguramos de que los queryparam inicien con el signo de interrogación
    filtroUrl = `?${filtroUrl.slice(1)}`;

    (filtroUrl !== "") ? filtroUrl = `/${path[1]}/factura/fecha${filtroUrl}` :  filtroUrl = `/${path[1]}/factura/medico/consulta/`;

    $('#fMedicos').DataTable().clear();
    $('#fMedicos').DataTable().destroy();

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
        // {
        //     data: "fecha_pago",
        //     render: function (data, type, row) {
        //         console.log(row);
        //         return formatToRealDate(data);
        //     },
        // },
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
        // {
        //     data: "factura_medico_id",
        //     render: function (data, type, row){
        //         return `
        //             <a href="#" data-bs-toggle="modal" data-bs-target="${row.estatus_fac == 1 ? "#modalAct" : ""}" onclick="marcarComoPagado('${row.estatus_fac == 1 ? data : 0}', false)">${row.estatus_fac == 1 ? "<span class='badge light badge-warning'>Pagar</span>" : "<span class='badge light badge-success'>Pagada</span>"}</a>
        //         `;
        //     }
        // },
        {
            data: "factura_medico_id",
            render: function (data, type, row) {

                // <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFMedico(${data})"><i class="fas fa-trash del-consulta"></i></a>
                // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                return `
                        <a href="#" onclick="openPopup('pdf/facturamedico/${data}')"><i class="fas fa-file-export"></i></a>
                    `
            }
        }

    ];

    const order = [[6, 'desc']];


    createDataTable({
        id: "#fMedicos",
        url: filtroUrl,
        columns: fMedicosColumns,
        order,
        processing: true,
        serverSide: true,
        requestData: {
            fecha_inicio: "2024-06-01",
            fecha_fin: "2024-06-30"
        }
    })
}

window.filtrarFacturaMedico = filtrarFacturaMedico;