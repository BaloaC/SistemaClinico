import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAll from "../global/getAll.js";
removeAddAccountant();
removeAddAnalist();
const path = location.pathname.split('/');

let modalOpened = false;
const modalRegister = document.getElementById("modalReg") ?? undefined;
const modalUpdate = document.getElementById("modalAct") ?? undefined;

const handleModalOpen = async (modalParent) => {
    if (modalOpened === false) {

        const empresaSelect = document.getElementById(modalParent === "#modalReg" ? "s-empresa" : "s-empresa-act");
        const seguroSelect = modalParent === "#modalReg" ? "#s-seguro" : "#s-seguro-act";
        const segurosList = await getAll("seguros/consulta");

        dinamicSelect2({
            obj: segurosList,
            selectSelector: seguroSelect,
            selectValue: "seguro_id",
            selectNames: ["rif", "nombre"],
            parentModal: modalParent,
            placeholder: "Seleccione un seguro",
            multiple: true
        });

        emptySelect2({
            selectSelector: empresaSelect,
            placeholder: "Debe seleccionar un seguro",
            parentModal: modalParent,
        })

        empresaSelect.disabled = true;

        $(seguroSelect).on("change", async function (e) {


            const segurosSeleccionadosValores = $(seguroSelect).val();

            const segurosSeleccionados = segurosList.filter(seguro => segurosSeleccionadosValores.some(seguroSeleccionado => seguro.seguro_id == seguroSeleccionado));

            // Obtener todas las empresas de los seguros seleccionados
            const todasLasEmpresas = segurosSeleccionados.flatMap(seguro => seguro?.empresas);
            const empresasUnicas = new Set();

            // Filtrar las empresas que coinciden en todos los seguros seleccionados y evitar duplicados
            const empresasFiltradas = todasLasEmpresas.filter(empresa => {
                const empresaId = empresa?.empresa_id;

                // Si no existe en el set lo añadimos
                if (!empresasUnicas.has(empresaId)) {
                    empresasUnicas.add(empresaId);
                    return segurosSeleccionados.every(seguro => seguro.empresas?.some(objeto => objeto?.empresa_id == empresaId));
                }

                return false;
            });

 
            $(empresaSelect).empty().select2();
            empresasFiltradas.length > 0 ? empresaSelect.classList.add("is-valid") : empresaSelect.classList.remove("is-valid");

            dinamicSelect2({
                obj: empresasFiltradas ?? [],
                selectSelector: empresaSelect,
                selectValue: "empresa_id",
                selectNames: ["rif","nombre_empresa"],
                parentModal: modalParent,
                placeholder: "Seleccione una empresa"
            });

            empresaSelect.disabled = false;
        });

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
if (modalUpdate) modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalAct"));

addEventListener("DOMContentLoaded", e => {

    const rol = Cookies.get("rol");

    let pacientes = $('#pacientes').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/pacientes/consulta/`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function (xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);

                $('#pacientes').DataTable().clear().draw();
            }
        },
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

                    switch (rol) {

                        case "1": return `
                        <a href="pacientes/historialmedico/${data}" target="_blank" class="view-info"><i class="fas fa-eye view-info""></i></a> 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-paciente" onclick="updatePaciente(${data})"><i class="fas fa-edit act-paciente"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deletePaciente(${data})"><i class="fas fa-trash del-paciente"></i></a>
                        `;

                        case "2": return `
                        <a href="pacientes/historialmedico/${data}" target="_blank" class="view-info"><i class="fas fa-eye view-info""></i></a> 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-paciente" onclick="updatePaciente(${data})"><i class="fas fa-edit act-paciente"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deletePaciente(${data})"><i class="fas fa-trash del-paciente"></i></a>
                        `;

                        case "4": return `
                        <a href="pacientes/historialmedico/${data}" target="_blank" class="view-info"><i class="fas fa-eye view-info""></i></a> 
                        `;

                        case "5": return `
                        <a href="pacientes/historialmedico/${data}" target="_blank" class="view-info"><i class="fas fa-eye view-info""></i></a> 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-paciente" onclick="updatePaciente(${data})"><i class="fas fa-edit act-paciente"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deletePaciente(${data})"><i class="fas fa-trash del-paciente"></i></a>
                        `;

                        default: return `-`;

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

        if (!data.nombre_seguro) data.nombre_seguro = "No aplica";
        if (!data.saldo_disponible) data.saldo_disponible = "No aplica";

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Fecha de Nacimiento: <b>${data.fecha_nacimiento}</b></td>
                </tr>
                <tr>
                    <td>Teléfono: <b>${data.telefono}</b></td>
                </tr>
                <tr>
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


