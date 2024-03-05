import concatItems from "../global/concatItems.js";
import dinamicSelect2, { emptyAllSelect2, emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');
const especialidadSelect = document.getElementById("s-especialidad");

let modalOpened = false;
export const registerStatusConsulta = {
    successfulConsulta: false,
};
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

addEventListener("DOMContentLoaded", async e => {

    removeAddAccountant();
    removeAddAnalist();


    let consultas = $('#consultas').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/factura/consultaSeguro/consulta/`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function (xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);

                $('#consultas').DataTable().clear().draw(); // Limpiar los datos existentes del DataTable
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
                data: null,
                render: function (data, type, row) {
                    if ("cedula_paciente" in data) return data.cedula_paciente;
                    else if ("beneficiado" in data) return data.beneficiado.cedula;
                    else {
                        return "Consulta por emergencia"
                    }
                }

            },
            {
                data: null,
                render: function (data, type, row) {
                    // console.log(data);
                    if ("nombre_paciente" in data) return `${data.nombre_paciente} ${data.apellido_paciente}`;
                    else if ("beneficiado" in data) return `${data.beneficiado.nombre} ${data.beneficiado.apellidos}`;
                    else {
                        return "Consulta por emergencia"
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {

                    if ("nombre_medico" in data) {
                        return `${data.nombre_medico} ${data.apellidos_medico}`;
                    } else if ("medico" in data && data.medico?.length > 0) {
                        return `${data.medico[0].nombre_medico} ${data.medico[0].apellidos_medico}`;
                    } else {
                        return "Consulta por emergencia"
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {

                    if ("nombre_especialidad" in data) {
                        return data.nombre_especialidad;
                    } else if ("medico" in data && data.medico?.length > 0) {
                        return `${data.medico[0].nombre_especialidad}`;
                    } else {
                        return "Consulta por emergencia"
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    if ("cedula_paciente" in data) return data.cedula_paciente;
                    else if ("titular" in data) return data.titular.cedula;
                    else if ("cedula_titular" in data) return data.cedula_titular;
                    else {
                        return "Consulta por emergencia"
                    }
                }
            },
            { data: "fecha_ocurrencia" },
            {
                data: "consulta_id",
                render: function (data, type, row) {

                    // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
                    return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteConsulta(${data})"><i class="fas fa-trash del-consulta"></i></a>
                    `
                }
            }

        ],
        order: [[6, 'desc']],
        // ! Ocultar los paneles por defecto 
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5, 6, 7],
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

            //                     if (rowData.tipo_paciente) return rowData.tipo_paciente === "1";
            //                     if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "1";
            //                 },
            //                 className: 'paciente-natural'
            //             },
            //             {
            //                 label: 'Paciente representante',
            //                 value: function (rowData, rowIdx) {
            //                     if (rowData.tipo_paciente) return rowData.tipo_paciente === "2";
            //                     if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "2";
            //                 },
            //                 className: 'paciente-representante'
            //             },
            //             {
            //                 label: 'Paciente asegurado',
            //                 value: function (rowData, rowIdx) {
            //                     if (rowData.tipo_paciente) return rowData.tipo_paciente === "3";
            //                     if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "3";
            //                 },
            //                 className: 'paciente-asegurado'
            //             },
            //             {
            //                 label: 'Paciente beneficiado',
            //                 value: function (rowData, rowIdx) {
            //                     if (rowData.tipo_paciente) return rowData.tipo_paciente === "4";
            //                     if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "4";
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
            //                     if (rowData.edad_paciente) {
            //                         return rowData.edad_paciente < 18;
            //                     }
            //                     if (rowData?.beneficiado.edad) {
            //                         return rowData.beneficiado.edad < 18;
            //                     }
            //                 },
            //                 className: 'may-18'
            //             },
            //             {
            //                 label: 'Mayores de 18 años',
            //                 value: function (rowData, rowIdx) {
            //                     if (rowData.edad_paciente) {
            //                         return rowData.edad_paciente > 18;
            //                     }
            //                     if (rowData?.beneficiado.edad) {
            //                         return rowData.beneficiado.edad > 18;
            //                     }
            //                 },
            //                 className: 'men-18'
            //             }
            //         ],
            //     },
            //     {
            //         header: 'Filtrar por tipo de consulta:',
            //         options: [
            //             {
            //                 label: 'Consulta normal',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.es_emergencia === 0;
            //                 },
            //                 className: 'noes_emergencia'
            //             },
            //             {
            //                 label: 'Consulta por emergencia',
            //                 value: function (rowData, rowIdx) {
            //                     return rowData.es_emergencia === 1;
            //                 },
            //                 className: 'es_emergencia'
            //             }
            //         ],
            //     }
            // ]
        },
        dom: 'Plfrtip'
    });

    function format(data) {

        console.log(data);

        if (data.clave == null) data.clave = "No aplica";
        let tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";
        if (data.es_emergencia === 1) tipo_cita = "Asegurada";

        let examenes = data.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data.insumos !== undefined ? concatItems(data.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";

        let recipes = `
        <tr>
            <td colspan="4">Recipes:</td>
        </tr>
        `;
        let factura = "";

        if (data.recipes) {

            data.recipes.forEach(el => {

                console.log(el);

                let tipo_medicamento = "";

                if (el.tipo_medicamento == 1) {
                    tipo_medicamento = "Cápsula";
                } else if (el.tipo_medicamento == 2) {
                    tipo_medicamento = "Jarabe";
                } else if (el.tipo_medicamento == 3) {
                    tipo_medicamento = "Inyección";
                } else if (el.tipo_medicamento == 4) {
                    tipo_medicamento = "Solución";
                } else {
                    tipo_medicamento = "Desconocido";
                }

                recipes += `
                <tr>
                    <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
                    <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
                    <td colspan"2">Uso: <br><b>${el.uso}</b></td>
                </tr>
            `;
            })
        } else {
            recipes += `
            <tr>
                <td colspan="4"><b>No hay recipes asigandos</b></td>
            </tr>
            `;
        }

        // <td>Nombre del medicamento: <br><b>${el.nombre_medicamento}</b></td>
        //         <td>Tipo de medicamento: <br><b>${tipo_medicamento}</b></td>
        //         <td colspan"2">Uso: <br><b>${el.uso}</b></td>

        if (data.factura) {

            factura = `
            <tr>
                <td colspan="4"><b>Factura consulta emergencia:</b></td>
            </tr>
            `;

            factura += `
            <tr>
                <td>Cantidad de consultas médicas: <br><b>${data.factura.cantidad_consultas_medicas}</b></td>
                <td>Consultas médicas: <br><b>$${data.factura.consultas_medicas}</b></td>
                <td>Cantidad laboratorio: <br><b>${data.factura.cantidad_laboratorios}</b></td>
                <td>Laboratorios: <br><b>$${data.factura.laboratorios}</b></td>
            </tr>
            <tr>
                <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
                <td>Medicamentos: <br><b>$${data.factura.medicamentos}</b></td>
                <td>Area de observación: <br><b>$${data.factura.area_observacion}</b></td>
                <td>Enfermería: <br><b>$${data.factura.enfermeria}</b></td>
            </tr>
            <tr>
                <td>Total insumos: <br><b>$${data.factura.total_insumos}</b></td>
                <td>Total exámenes: <br><b>$${data.factura.total_examenes}</b></td>
                <td>Total consulta: <br><b>$${data.factura.total_consulta}</b></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td colspan="4"><b>Monto en bs:</b></td>
            </tr>
             <tr>
                <td>Consultas médicas: <br><b>${data.factura.consultas_medicas_bs} Bs</b></td>
                <td>Laboratorios: <br><b>${data.factura.laboratorios_bs} Bs</b></td>
            </tr>
            <tr>
                <td>Medicamentos: <br><b>${data.factura.medicamentos_bs} Bs</b></td>
                <td>Area de observación: <br><b>${data.factura.area_observacion_bs} Bs</b></td>
                <td>Enfermería: <br><b>${data.factura.enfermeria_bs} Bs</b></td>
            </tr>
            <tr>
                <td>Total insumos: <br><b>${data.factura.total_insumos_bs} Bs</b></td>
                <td>Total exámenes: <br><b>${data.factura.total_examenes_bs} Bs</b></td>
                <td>Total consulta: <br><b>${data.factura.total_consulta_bs} Bs</b></td>
            </tr>
        `;
        }

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Peso: <br><b>${data.peso ? data.peso + " " + "kg" : "No especificado"} </b></td>
                    <td>Estatura: <br><b>${data.altura ? data.altura + " " + "m" : "No especificado"}</b></td>
                    <td>Fecha Cita: <br><b>${data.fecha_cita ?? "No aplica"}</b></td>
                    <td>Motivo cita: <br><b>${data.motivo_cita ?? "No aplica"}</b></td>
                </tr>
                <tr class="blue-td">
                    <td>Clave: <br><b>${data.clave}</b></td>
                    <td>Exámenes realizados: <br><b>${examenes}</b></td>
                    <td>Insumos utilizados: <br><b>${insumos}</b></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td colspan="4">Indicaciones: <br><b>${indicaciones}</b></td>
                </tr>
                <tr><td><br></td></tr>
                ${recipes}
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                ${factura}
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add text-nowrap mb-3" href="#" onclick="openPopup('pdf/consulta/${data.consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
                </tr>
            </table>
        `
    }

    $('#consultas').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = consultas.row(tr);

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
