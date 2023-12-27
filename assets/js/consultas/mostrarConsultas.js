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

const handleModalOpen = async () => {


    // En caso de que se haya registrado correctamente una consulta por cita, volvemos actualizar el select de las citas
    if (registerStatus.successfulConsulta === true) {

        const infoCitas = await getAll("citas/consulta");
        let listCitas;

        if ('result' in infoCitas && infoCitas.result.code === false) listCitas = [];


        if (infoCitas.length > 0) {
            listCitas = infoCitas.filter(cita => cita.estatus_cit === "1");
        }

        emptyAllSelect2({
            selectSelector: "#s-cita",
            placeholder: "Seleccione una cita",
            parentModal: "#modalReg"
        });

        dinamicSelect2({
            obj: listCitas ?? [],
            selectSelector: "#s-cita",
            selectValue: "cita_id",
            selectNames: ["cita_id", "cedula_paciente", "nombre_paciente-apellido_paciente", "motivo_cita"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una cita"
        });

        $("#s-cita").val([]).trigger("change");
        document.getElementById("s-cita").classList.remove("is-valid");

        registerStatus.successfulConsulta = false;
    }

    if (modalOpened === false) {

        const medicosList = await getAll("medicos/consulta");
        const pacientesList = await getAll("pacientes/consulta");
        const examenesList = await getAll("examenes/consulta");
        const segurosList = await getAll("seguros/consulta");
        const infoCitas = await getAll("citas/consulta");
        let listCitas;

        if ('result' in infoCitas && infoCitas.result.code === false) listCitas = [];


        if (infoCitas.length > 0) {
            listCitas = infoCitas.filter(cita => cita.estatus_cit === "1");
        }

        dinamicSelect2({
            obj: listCitas ?? [],
            selectSelector: "#s-cita",
            selectValue: "cita_id",
            selectNames: ["cita_id", "cedula_paciente", "nombre_paciente-apellido_paciente", "motivo_cita"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una cita"
        });

        dinamicSelect2({
            obj: examenesList,
            selectSelector: "#s-examen",
            selectValue: "examen_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione los exámenes",
            multiple: true
        });

        dinamicSelect2({
            obj: segurosList,
            selectSelector: "#s-seguro-emergencia",
            selectValue: "seguro_id",
            selectNames: ["rif", "nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un seguro"
        });

        dinamicSelect2({
            obj: pacientesList,
            selectSelector: "#s-paciente",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un paciente",
        });

        document.getElementById("s-paciente").disabled = true;


        dinamicSelect2({
            obj: medicosList,
            selectSelector: "#s-medico",
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un médico"
        });


        document.getElementById("s-medico").disabled = true;

        emptySelect2({
            selectSelector: especialidadSelect,
            placeholder: "Debe seleccionar un médico",
            parentModal: "#modalReg",
        })

        especialidadSelect.disabled = true;

        $("#s-medico").on("change", async function (e) {


            let medico_id = this.value;
            const infoMedico = await getById("medicos", medico_id);

            $(especialidadSelect).empty().select2();

            dinamicSelect2({
                obj: infoMedico[0]?.especialidad ?? [],
                selectSelector: especialidadSelect,
                selectValue: "especialidad_id",
                selectNames: ["nombre_especialidad"],
                parentModal: "#modalReg",
                placeholder: "Seleccione una especialidad"
            });

            especialidadSelect.disabled = false;
            especialidadSelect.classList.add("is-valid");

        });

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());
if (modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen());


addEventListener("DOMContentLoaded", async e => {

    removeAddAccountant();
    removeAddAnalist();


    let consultas = $('#consultas').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/consultas/consulta/`,
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
                    if ("beneficiado" in data) return data.beneficiado.cedula;
                }

            },
            {
                data: null,
                render: function (data, type, row) {
                    if ("nombre_paciente" in data) return data.nombre_paciente;
                    if ("beneficiado" in data) return data.beneficiado.nombre;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    if ("nombre_medico" in data) {
                        // console.log(data);
                        return data.nombre_medico;
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
                    } else {
                        return "Consulta por emergencia"
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    if ("cedula_paciente" in data) return data.cedula_paciente;
                    if ("titular" in data) return data.titular.cedula;
                    if ("cedula_titular" in data) return data.cedula_titular;
                }
            },
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
        let factura = "";

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
                <td>Consultas médicas: <br><b>${data.factura.consultas_medicas}</b></td>
                <td>Cantidad laboratorio: <br><b>${data.factura.cantidad_laboratorios}</b></td>
                <td>Laboratorios: <br><b>${data.factura.laboratorios}</b></td>
            </tr>
            <tr>
                <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
                <td>Medicamentos: <br><b>${data.factura.medicamentos}</b></td>
                <td>Area de observación: <br><b>${data.factura.area_observacion}</b></td>
                <td>Enfermería: <br><b>${data.factura.enfermeria}</b></td>
            </tr>
            <tr>
                <td>Total insumos: <br><b>${data.factura.total_insumos}</b></td>
                <td>Total exámenes: <br><b>${data.factura.total_examenes}</b></td>
                <td>Total consulta: <br><b>${data.factura.total_consulta}</b></td>
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
        console.log(tipo_cita);

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td>Peso: <br><b>${data.peso}</b></td>
                    <td>Estatura: <br><b>${data.altura}</b></td>
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
                    <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/consulta/${data.consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a> <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg${tipo_cita}" onclick="pagarConsulta(${tipo_cita},${data.paciente_id}, ${data.consulta_id})"><i class="fa-sm fas fa-plus"></i> Pagar consulta</button></td>
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


