import dinamicSelect2, { emptySelect2 } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
import getAll from "../global/getAll.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";
import getById from "../global/getById.js";
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
        // const segurosList = await getAll("seguros/consulta");

        emptySelect2({
            selectSelector: seguroSelect,
            placeholder: "Debe seleccionar una empresa",
            parentModal: modalParent,
        })

        emptySelect2({
            selectSelector: empresaSelect,
            placeholder: "Seleccione una empresa",
            parentModal: modalParent,
        })

        dinamicSelect2({
            // obj: titularesList,
            selectSelector: empresaSelect,
            selectValue: "empresa_id",
            selectNames: ["rif", "nombre_empresa"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una empresa",
            ajax: true,
            ajaxUrl: "empresas/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const data1 = [];

                if (typeof data === "object" && data?.data !== 0) {

                    data?.data?.forEach(object => {

                        const { empresa_id: valorPropiedad1, nombre, rif} = object;

                        data1.push({ id: valorPropiedad1, text: `${rif} - ${nombre}`});
                    });
                }

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1 ?? []
                };
            }
        });

        $(empresaSelect).on("change", async function (e) {
            
            $(seguroSelect).empty().select2();

            dinamicSelect2({
                // obj: segurosList,
                selectSelector: seguroSelect,
                selectValue: "seguro_id",
                selectNames: ["rif", "nombre"],
                parentModal: "#modalReg",
                placeholder: "Debe seleccionar una empresa primero",ajax: true,
                ajaxUrl: `seguros/empresas/${this.value}`,
                queryPage: false,
                processResultsAjax: function (data, params) {
    
                    const data1 = [];
    
                    if (typeof data === "object" && data?.data !== 0) {
    
                        data?.data?.forEach(object => {
    
                            const { seguro_id: valorPropiedad1, nombre, rif} = object;
    
                            data1.push({ id: valorPropiedad1, text: `${rif} - ${nombre}`});
                        });
                    }
    
                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1 ?? []
                    };
                }
            });
        });

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalReg"));
if (modalUpdate) modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalAct"));

addEventListener("DOMContentLoaded", e => {

    const rol = Cookies.get("rol");

    const pacientesColumns = [
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
                        `;

                    default: return `-`;

                }
            },
            visible: rol === "4" ? false : true
        }

    ];

    const columnDefsPacientes = [{
        searchPanes: {
            show: false,
        },
        targets: [0, 1, 2, 3, 4, 5],
    }];

    const searchPanesPacientes = {
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
    };

    const format = (data) => {

        if (!data.nombre_seguro) data.nombre_seguro = "No aplica";
        if (!data.saldo_disponible) data.saldo_disponible = "No aplica";

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Fecha de Nacimiento: <b>${formatToRealDate(data.fecha_nacimiento)}</b></td>
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

    createDataTable({
        id: "#pacientes",
        columns: pacientesColumns,
        url: `/${path[1]}/pacientes/consulta/`,
        format,
        processing: true,
        serverSide: true
    });




});


