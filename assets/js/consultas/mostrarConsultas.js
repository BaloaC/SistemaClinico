import concatItems from "../global/concatItems.js";
import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";

const path = location.pathname.split('/');
const especialidadSelect = document.getElementById("s-especialidad");

select2OnClick({
    selectSelector: "#s-paciente",
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    module: "pacientes/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un paciente"
});

// TODO: Colocar en la vista los horarios disponible de este medico
// select2OnClick({
//     selectSelector: "#s-medico",
//     selectValue: "medico_id",
//     selectNames: ["cedula", "nombre-apellidos"],
//     module: "medicos/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione un médico"
// });


const citasSelect = document.getElementById("s-cita");

emptySelect2({
    selectSelector: citasSelect,
    placeholder: "Debe seleccionar un paciente",
    parentModal: "#modalReg"
})

citasSelect.disabled = true;

$("#s-paciente").on("change", async function (e) {

    let paciente_id = this.value;

    if (!paciente_id) return;

    let infoCitas = await getById("citas/paciente", paciente_id);

    $(citasSelect).empty().select2();

    if ('result' in infoCitas && infoCitas.result.code === false) infoCitas = [];

    dinamicSelect2({
        obj: infoCitas,
        selectSelector: citasSelect ?? [],
        selectValue: "cita_id",
        selectNames: ["cita_id", "motivo_cita"],
        parentModal: "#modalReg",
        placeholder: "Seleccione un paciente"
    });

    citasSelect.disabled = false;
})

// select2OnClick({
//     selectSelector: "#s-cita",
//     selectValue: "cita_id",
//     selectNames: ["cita_id", "motivo_cita"],
//     module: "citas/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione una cita"
// });

select2OnClick({
    selectSelector: "#s-examen",
    selectValue: "examen_id",
    selectNames: ["nombre"],
    module: "examenes/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione los exámenes",
    multiple: true
});

// select2OnClick({
//     selectSelector: "#s-examen",
//     selectValue: "examen_id",
//     selectNames: ["nombre"],
//     module: "examenes/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione los exámenes",
//     multiple: true
// });

select2OnClick({
    selectSelector: "#s-insumo",
    selectValue: "insumo_id",
    selectNames: ["nombre"],
    module: "insumos/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione el insumo"
});

select2OnClick({
    selectSelector: "#s-medicamento",
    selectValue: "medicamento_id",
    selectNames: ["nombre_medicamento"],
    module: "medicamento/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione el medicamento"
});
// especialidadSelect.disabled = true;
// TODO: Al seleccionar/cambiar el valor del medico, cargar unicamente sus especialidades, crear el input vacio afuera
// $("#s-medico").on("change", async function (e) {

//     const especialidades = await getAll("especialidades/consulta");
//     $(especialidadSelect).empty().select2();

//     dinamicSelect2({
//         obj: especialidades,
//         selectSelector: especialidadSelect,
//         selectValue: "especialidad_id",
//         selectNames: ["nombre"],
//         parentModal: "#modalReg",
//         placeholder: "Seleccione una especialidad"
//     });

//     especialidadSelect.disabled = false;
// })


addEventListener("DOMContentLoaded", e => {
    removeAddAccountant();
    removeAddAnalist();
    let consultas = $('#consultas').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/consultas/consulta/`,
        columns: [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { data: "cedula_paciente" },
            { data: "nombre_paciente" },
            { data: "cedula_medico" },
            { data: "nombre_medico" },
            { data: "nombre_especialidad" },
            { data: "cedula_titular" },
            { data: "fecha_consulta" },
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
                            label: 'Paciente representante',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "2";
                            },
                            className: 'paciente-representante'
                        },
                        {
                            label: 'Paciente asegurado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "3";
                            },
                            className: 'paciente-asegurado'
                        },
                        {
                            label: 'Paciente beneficiado',
                            value: function (rowData, rowIdx) {
                                return rowData.tipo_paciente === "4";
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

        if (data.clave == null) data.clave = "No aplica";
        let tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal"; 

        let examenes = data.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data.insumos !== undefined ? concatItems(data.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";

        let recipes = `
        <tr>
            <td colspan="4">Recipes:</td>
        </tr>
        `;

        if (data.recipes) {

            data.recipes.forEach(el => {

                let tipo_medicamento = "";

                if (el.tipo_medicamento == 1) {
                    tipo_medicamento = "Cápsula";
                } else if (el.tipo_medicamento == 2) {
                    tipo_medicamento = "Jarabe";
                } else if (el.tipo_medicamento == 3) {
                    tipo_medicamento = "Inyección";
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


        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Peso: <br><b>${data.peso}</b></td>
                    <td>Altura: <br><b>${data.altura}</b></td>
                    <td>Fecha Cita: <br><b>${data.fecha_cita}</b></td>
                    <td>Motivo cita: <br><b>${data.motivo_cita}</b></td>
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
                <tr>
                    <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/consulta/${data.consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a> <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg${tipo_cita}"><i class="fa-sm fas fa-plus"></i> Pagar consulta</button></td>
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


