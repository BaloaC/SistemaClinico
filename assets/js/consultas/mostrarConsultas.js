import concatItems from "../global/concatItems.js";
import dinamicSelect2, { emptyAllSelect2, emptySelect2 } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import { removeAddAccountant, removeAddAnalist } from "../global/validateRol.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');
const especialidadSelect = document.getElementById("s-especialidad");
const medicoSelect = document.getElementById("s-medico");
export let especialidadId = { valor: "" };

let modalOpened = false;
export const registerStatusConsulta = {
    successfulConsulta: false,
};
const modalRegConsulta = document.getElementById("modalRegConsulta") ?? undefined;
const modalRegister = document.getElementById("modalReg") ?? undefined;

const handleModalOpen = async () => {

    if (modalOpened === false) {

        //Inicializamos los select2
        emptyAllSelect2({
            selectSelector: "#s-cita",
            placeholder: "Cargando",
            parentModal: "#modalReg"
        });

        emptySelect2({
            selectSelector: "#s-examen",
            placeholder: "Cargando",
            parentModal: "#modalReg",
        });

        emptySelect2({
            selectSelector: "#s-examen-sinConsulta",
            placeholder: "Seleccione un examen",
            parentModal: "#modalReg",
        });

        emptyAllSelect2({
            selectSelector: "#s-paciente",
            placeholder: "Cargando",
            parentModal: "#modalReg"
        });

        emptyAllSelect2({
            selectSelector: "#s-paciente-sinConsulta",
            placeholder: "Cargando",
            parentModal: "#modalReg"
        });

        emptyAllSelect2({
            selectSelector: "#s-medico",
            placeholder: "Debe seleccionar una especialidad",
            parentModal: "#modalReg"
        });

        emptyAllSelect2({
            selectSelector: "#s-medico-sinConsulta",
            placeholder: "Debe seleccionar una especialidad",
            parentModal: "#modalReg"
        });

        emptyAllSelect2({
            selectSelector: "#s-medicamento",
            placeholder: "Debe seleccionar una especialidad",
            parentModal: "#modalReg"
        });

        emptySelect2({
            selectSelector: especialidadSelect,
            placeholder: "Debe seleccionar un médico",
            parentModal: "#modalReg",
        });

        emptySelect2({
            selectSelector: "#s-especialidad-sinConsulta",
            placeholder: "Debe seleccionar un médico",
            parentModal: "#modalReg",
        });

        emptySelect2({
            selectSelector: "#s-seguro-emergencia",
            placeholder: "Debe seleccionar un paciente",
            parentModal: "#modalReg"
        });


        document.getElementById("s-paciente").disabled = true;
        medicoSelect.disabled = true;
        document.getElementById("s-seguro-emergencia").disabled = true;

        dinamicSelect2({

            selectSelector: "#s-cita",
            selectValue: "cita_id",
            selectNames: ["cita_id", "cedula_titular", "motivo_cita"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una cita",
            ajax: true,
            ajaxUrl: "citas/consulta?estatus=1",
            // queryPage: false,
            processResultsAjax: function (data, params) {

                const data1 = [];

                data?.data.map(object => {

                    const { cita_id: valorPropiedad1, cedula_titular: cedulaTitular, motivo_cita: motivoCita } = object;

                    // if (object.estatus_cit == "1") {
                    data1.push({ id: valorPropiedad1, text: `${valorPropiedad1} - ${cedulaTitular} - ${motivoCita}` });
                    // }
                });

                // Transforms the top-level key of the response object from 'data' to 'results'
                return { results: data1, pagination: { more: data1.length } };
            }
        });

        $("#s-cita").val([]).trigger("change")
        document.getElementById("s-cita").classList.remove("is-valid");

        dinamicSelect2({
            // obj: examenesList,
            selectSelector: "#s-referidos",
            selectValue: "especialidad_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione los exámenes",
            multiple: true,
            ajax: true,
            ajaxUrl: "especialidades/consulta",
            processResultsAjax: function (data, params) {

                params.page = params.page || 1;

                const data1 = data?.data.map(object => {
                    const { especialidad_id: valorPropiedad1, nombre: nombreExamen } = object;
                    return { id: valorPropiedad1, text: nombreExamen };
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

        const select2Paciente = {
            selectSelector: "#s-paciente",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un paciente",
            ajax: true,
            ajaxUrl: "pacientes/consulta",
            processResultsAjax: function (data, params) {

                const data1 = [];

                if (typeof data === "object" && data?.data !== 0) {
                    data?.data.forEach(object => {
                        const { paciente_id: valorPropiedad1, cedula, nombre, apellidos, tipo_paciente } = object;

                        const handleTipoPaciente = (tipo_paciente) => {
                            if (tipo_paciente == 1) tipo_paciente = "Natural";
                            else if (tipo_paciente == 2) tipo_paciente = "Representante";
                            else if (tipo_paciente == 3) tipo_paciente = "Asegurado";
                            else if (tipo_paciente == 4) tipo_paciente = "Beneficiado";

                            return tipo_paciente
                        }

                        data1.push({ id: valorPropiedad1, text: `${cedula} - ${nombre} ${apellidos} - ${handleTipoPaciente(tipo_paciente)}` });
                    });
                }

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1 ?? [],
                    pagination: {
                        more: data1.length
                    }
                };
            }
        }

        const select2Especialidad = {
            selectSelector: especialidadSelect,
            selectValue: "especialidad_id",
            selectNames: ["nombre_especialidad"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una especialidad",
            ajax: true,
            ajaxUrl: "especialidades/medicos",
            processResultsAjax: function (data, params) {

                params.page = params.page || 1;

                const data1 = data?.data.map(object => {
                    const { especialidad_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                    return { id: valorPropiedad1, text: valorPropiedad2 };
                });

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1,
                    pagination: {
                        more: data1.length
                    }
                };
            }
        }

        // dinamicSelect2(select2Paciente);

        // Para crear el select2 sin consulta
        select2Paciente.selectSelector = "#s-paciente-sinConsulta";
        dinamicSelect2(select2Paciente);

        dinamicSelect2(select2Especialidad);

        // Para crear el select2 sin consulta
        select2Especialidad.selectSelector = "#s-especialidad-sinConsulta"
        dinamicSelect2(select2Especialidad);

        // $("#s-medico").val([]).trigger("change")
        document.getElementById("s-medico").classList.remove("is-valid");

        $("#s-cita").on("change", async function (e) {

            const cita = await getById("citas", this.value);

            // Si se selecciona una cita, se toma la fecha de la cita
            document.getElementById("fecha_consulta_cita").value = cita.fecha_cita;

            // Lógica para manejar el select de examenes según una cita sea seleccionada
            $("#s-examen").empty().select2();

            dinamicSelect2({
                selectSelector: "#s-examen",
                selectValue: "examen_id",
                selectNames: ["nombre"],
                parentModal: "#modalReg",
                placeholder: "Seleccione los exámenes",
                multiple: true,
                ajax: true,
                ajaxUrl: `examenes/especialidad/${cita.especialidad_id}`,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = data?.data.map(object => {
                        const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                        return { id: valorPropiedad1, text: nombreExamen };
                    });

                    // Filtramos los examenes colocados en las citas, para que no puedan ser introducidos nuevamente por consulta
                    const filteredData = data1.filter(item => {
                        return !cita?.examenes.some(examen => examen.examen_id === item.id);
                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return { results: filteredData };
                }
            });

            const medicamentosSelect = document.querySelectorAll(".medicamento-id");

            // Reinicializar los select2 de los medicamentos para que se puedan actualizar según la especilidad
            medicamentosSelect.forEach((select, key) => {

                $(select).empty().select2();

                // Seleccionamos la especialidad en los filtros para que carguen
                const data = {
                    id: cita.especialidad_id,
                    text: cita.nombre_especialidad
                };

                const newOption = new Option(data.text, data.id, true, true);
                $(`#s-especialidadm${key === 0 ? "" : key}`).append(newOption).trigger('change');
                $(`#s-especialidadm${key === 0 ? "" : key}`).val([]).trigger('change');

                dinamicSelect2({
                    // obj: medicamentosList,
                    selectSelector: select,
                    selectValue: "medicamento_id",
                    selectNames: ["nombre_medicamento"],
                    parentModal: "#modalReg",
                    placeholder: "Seleccione el medicamento",
                    ajax: true,
                    ajaxUrl: `medicamento/especialidad/${cita?.especialidad_id}`,
                    queryPage: false,
                    processResultsAjax: function (data, params) {

                        const existingSelects = document.querySelectorAll(`.medicamento-id`);

                        let selectedOptions = [];

                        // Recorremos los select que existen
                        existingSelects.forEach(select2 => {
                            if (document.getElementById(`${select.id}`).value != select2.value) {
                                selectedOptions.push(select2.value);
                            }
                        })

                        const data1 = [];

                        data?.data.forEach(object => {
                            const { medicamento_id: valorPropiedad1, nombre_medicamento: nombre_medicamento } = object;
                            let isDuplicate = false;

                            selectedOptions?.forEach(select => {
                                if (select == object.medicamento_id) {
                                    isDuplicate = true;
                                    return; // Salir del bucle forEach si se encuentra una duplicación
                                }
                            });

                            if (!isDuplicate) {
                                data1.push({ id: valorPropiedad1, text: nombre_medicamento });
                            }
                        });

                        // Transforms the top-level key of the response object from 'data' to 'results'
                        return { results: data1 };
                    }
                });
            });

        });

        $("#s-especialidad-sinConsulta").on("change", async function (e) {

            let especialidad_id = this.value;

            // Exámenes por especialidad select2

            $("#s-examen-sinConsulta").empty().select2();

            dinamicSelect2({
                selectSelector: "#s-examen-sinConsulta",
                selectValue: "examen_id",
                selectNames: ["nombre"],
                parentModal: "#modalReg",
                placeholder: "Seleccione los exámenes",
                multiple: true,
                ajax: true,
                ajaxUrl: `examenes/especialidad/${especialidad_id}`,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = data?.data.map(object => {
                        const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                        return { id: valorPropiedad1, text: nombreExamen };
                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return { results: data1 };
                }
            });

            // Médico select
            $("#s-medico-sinConsulta").empty().select2();

            dinamicSelect2({
                selectSelector: "#s-medico-sinConsulta",
                selectValue: "medico_id",
                selectNames: ["cedula", "nombre-apellidos"],
                ajax: true,
                ajaxUrl: `/medicos/especialidad/${especialidad_id}`,
                parentModal: "#modalReg",
                placeholder: "Seleccione un médico",
                queryPage: false,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = [];

                    data?.data.map(object => {
                        const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico, especialidad } = object;
                        data1.push({ id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` });

                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1
                    };
                }
            });

            medicoSelect.disabled = false;
        });

        $(especialidadSelect).on("change", async function (e) {

            let especialidad_id = this.value;
            // Exámenes por especialidad select2

            if (document.getElementById("s-tipo_consulta").value !== "1") {

                $("#s-examen").empty().select2();

                dinamicSelect2({
                    selectSelector: "#s-examen",
                    selectValue: "examen_id",
                    selectNames: ["nombre"],
                    parentModal: "#modalReg",
                    placeholder: "Seleccione los exámenes",
                    multiple: true,
                    ajax: true,
                    ajaxUrl: `examenes/especialidad/${especialidad_id}`,
                    processResultsAjax: function (data, params) {

                        params.page = params.page || 1;

                        const data1 = data?.data.map(object => {
                            const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                            return { id: valorPropiedad1, text: nombreExamen };
                        });

                        // Transforms the top-level key of the response object from 'data' to 'results'
                        return { results: data1 };
                    }
                });

            }

            // Médico select
            $(medicoSelect).empty().select2();

            dinamicSelect2({
                selectSelector: "#s-medico",
                selectValue: "medico_id",
                selectNames: ["cedula", "nombre-apellidos"],
                ajax: true,
                ajaxUrl: `/medicos/especialidad/${especialidad_id}`,
                parentModal: "#modalReg",
                placeholder: "Seleccione un médico",
                queryPage: false,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = [];

                    data?.data.map(object => {
                        const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico, especialidad } = object;
                        data1.push({ id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` });

                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1
                    };
                }
            });

            medicoSelect.disabled = false;

            // Logica para el select2 de los medicamentos
            const especialidadSelected = await getById("especialidades", this.value);
            const medicamentosSelect = document.querySelectorAll(".medicamento-id");

            // Reinicializar los select2 de los medicamentos para que se puedan actualizar según la especilidad
            medicamentosSelect.forEach((select, key) => {

                $(select).empty().select2();

                // Seleccionamos la especialidad en los filtros para que carguen
                const data = {
                    id: especialidadSelected.especialidad_id,
                    text: especialidadSelected.nombre
                };

                const newOption = new Option(data.text, data.id, true, true);
                $(`#s-especialidadm${key === 0 ? "" : key}`).append(newOption).trigger('change');
                $(`#s-especialidadm${key === 0 ? "" : key}`).val([]).trigger('change');

                dinamicSelect2({
                    selectSelector: select,
                    selectValue: "medicamento_id",
                    selectNames: ["nombre_medicamento"],
                    parentModal: "#modalReg",
                    placeholder: "Seleccione el medicamento",
                    ajax: true,
                    ajaxUrl: `medicamento/especialidad/${especialidad_id}`,
                    queryPage: false,
                    processResultsAjax: function (data, params) {

                        const existingSelects = document.querySelectorAll(`.medicamento-id`);

                        let selectedOptions = [];

                        // Recorremos los select que existen
                        existingSelects.forEach(select2 => {
                            if (document.getElementById(`${select.id}`).value != select2.value) {
                                selectedOptions.push(select2.value);
                            }
                        })

                        const data1 = [];

                        data?.data.forEach(object => {
                            const { medicamento_id: valorPropiedad1, nombre_medicamento: nombre_medicamento } = object;
                            let isDuplicate = false;

                            selectedOptions?.forEach(select => {
                                if (select == object.medicamento_id) {
                                    isDuplicate = true;
                                    return; // Salir del bucle forEach si se encuentra una duplicación
                                }
                            });

                            if (!isDuplicate) {
                                data1.push({ id: valorPropiedad1, text: nombre_medicamento });
                            }
                        });

                        // Transforms the top-level key of the response object from 'data' to 'results'
                        return { results: data1 };
                    }
                });
            });
        });

        $("#s-paciente").on("change", async function (e) {

            let paciente_id = this.value;
            const infoPaciente = await getById("pacientes", paciente_id);

            $("#s-seguro-emergencia").empty().select2();

            dinamicSelect2({
                obj: infoPaciente?.seguro ?? [],
                selectSelector: "#s-seguro-emergencia",
                selectValue: "seguro_id",
                selectNames: ["rif", "nombre_seguro"],
                parentModal: "#modalReg",
                placeholder: "Seleccione un seguro"
            });

            // const consultaSinCita = document.getElementById("s-tipo_consulta").value;
            // document.getElementById("s-seguro-emergencia").disabled = consultaSinCita == 1 ? true : false;
            if (document.getElementById("s-seguro-emergencia").value) document.getElementById("s-seguro-emergencia").classList.add("is-valid");


            const popover = new bootstrap.Popover(document.getElementById('cedula_beneficiado'), {
                container: 'body',
                title: 'Sugerencia',
                html: true,
                placement: 'bottom',
                sanitize: false,
                content() {
                    return `
                        <div>
                            <h6 style="font-size: 1rem">¿Desea que la cédula del beneficiado sea igual que la del paciente titular?</h6>
                            <a id="acceptSuggestion" class="popoverOptions">Sí</a>
                            <a id="dismissPopover" class="popoverOptions">Ignorar</a>
                        </div>`;
                }
            })

            const hidePopoverHandle = (time) => {
                setTimeout(() => {
                    if (popover._isEnabled) popover.hide();
                }, time);
                setTimeout(() => {
                    if (popover._isEnabled) popover.dispose();
                }, time + 500);
            }

            const acceptSuggestionHandle = () => {

                let cedulaPaciente = infoPaciente.cedula;
                document.getElementById("cedula_beneficiado").value = cedulaPaciente;
                document.getElementById("cedula_beneficiado").dispatchEvent(new Event("keyup"));
            }

            document.getElementById("cedula_beneficiado").addEventListener("shown.bs.popover", () => {

                document.getElementById("dismissPopover").addEventListener("click", () => {
                    hidePopoverHandle(0);
                    return;
                });

                document.getElementById("acceptSuggestion").addEventListener("click", () => {
                    acceptSuggestionHandle();
                    hidePopoverHandle(0);
                    return;
                });

                hidePopoverHandle(3000);
            });

        });

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());
if (modalRegConsulta) modalRegConsulta.addEventListener('show.bs.modal', async () => await handleModalOpen());


addEventListener("DOMContentLoaded", async e => {

    // Ocultar botones de acuerdo a los roles
    removeAddAccountant();
    removeAddAnalist();

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const consultasColumns = [
        {
            "className": 'dt-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        }, { data: "consulta_id" },
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
                if ("nombre_paciente" in data) return `${data.nombre_paciente} ${data.apellido_paciente}`;
                if ("beneficiado" in data) return `${data.beneficiado.nombre} ${data.beneficiado.apellidos}`;
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
                if ("titular" in data) return data.titular.cedula;
                if ("cedula_titular" in data) return data.cedula_titular;
                if ("cedula_paciente" in data) return data.cedula_paciente;
            }
        },
        {
            data: "fecha_consulta",
            render: function (data, type, row) {
                return formatToRealDate(data);
            },
        },
    ];

    const columnDefsConsultas = [
        {
            type: 'datetime-moment',
            targets: 6
        },
        {
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3, 4, 5, 6],
        }
    ];

    const searchPanesConsultas = {
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

                            if (rowData.tipo_paciente) return rowData.tipo_paciente === "1";
                            if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "1";
                        },
                        className: 'paciente-natural'
                    },
                    {
                        label: 'Paciente representante',
                        value: function (rowData, rowIdx) {
                            if (rowData.tipo_paciente) return rowData.tipo_paciente === "2";
                            if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "2";
                        },
                        className: 'paciente-representante'
                    },
                    {
                        label: 'Paciente asegurado',
                        value: function (rowData, rowIdx) {
                            if (rowData.tipo_paciente) return rowData.tipo_paciente === "3";
                            if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "3";
                        },
                        className: 'paciente-asegurado'
                    },
                    {
                        label: 'Paciente beneficiado',
                        value: function (rowData, rowIdx) {
                            if (rowData.tipo_paciente) return rowData.tipo_paciente === "4";
                            if (rowData?.beneficiado.tipo_paciente) return rowData.beneficiado.tipo_paciente === "4";
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
                            if (rowData.edad_paciente) {
                                return rowData.edad_paciente < 18;
                            }
                            if (rowData?.beneficiado.edad) {
                                return rowData.beneficiado.edad < 18;
                            }
                        },
                        className: 'may-18'
                    },
                    {
                        label: 'Mayores de 18 años',
                        value: function (rowData, rowIdx) {
                            if (rowData.edad_paciente) {
                                return rowData.edad_paciente > 18;
                            }
                            if (rowData?.beneficiado.edad) {
                                return rowData.beneficiado.edad > 18;
                            }
                        },
                        className: 'men-18'
                    }
                ],
            },
            {
                header: 'Filtrar por tipo de consulta:',
                options: [
                    {
                        label: 'Consulta normal',
                        value: function (rowData, rowIdx) {
                            return rowData.es_emergencia === 0;
                        },
                        className: 'noes_emergencia'
                    },
                    {
                        label: 'Consulta por emergencia',
                        value: function (rowData, rowIdx) {
                            return rowData.es_emergencia === 1;
                        },
                        className: 'es_emergencia'
                    }
                ],
            }
        ]
    }

    const order = [[6, 'desc']];

    const format = (data) => {

        if (data.clave == null) data.clave = "No aplica";
        let tipo_cita = data.tipo_cita == 2 ? "Asegurada" : "Normal";
        if (data.es_emergencia === 1) tipo_cita = "Asegurada";

        let examenes = data.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data.insumos !== undefined ? concatItems(data.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación",
            referidos = data.referidos !== undefined ? concatItems(data.referidos, "nombre", "No se refirió a ningún médico", ".") : "No se refirió a ningún médico";

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
                <td colspan="4"><b>No hay recipes asignados</b></td>
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
                <td>Cantidad de medicamentos: <br><b>${data.factura.cantidad_medicamentos}</b></td>
                <td>Cantidad laboratorio: <br><b>${data.factura.cantidad_laboratorios}</b></td>
                
            </tr>
            <tr>
                <td>Consultas médicas: <br><b>$${data.factura.consultas_medicas}</b></td>
                <td>Laboratorios: <br><b>$${data.factura.laboratorios}</b></td>
            </tr>
            <tr>
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
                    ${data.es_emergencia != 1 && data?.fecha_cita
                ? `<td>Fecha Cita: <br><b>${formatToRealDate(data.fecha_cita) ?? "No aplica"}</b></td>
                        <td>Motivo cita: <br><b>${data.motivo_cita ?? "No aplica"}</b></td>
                        <td>Clave: <br><b>${data.clave}</b></td>`
                : ""
            }
                </tr>
                <tr class="blue-td">
                    <td>Exámenes realizados: <br><b>${examenes}</b></td>
                    ${data.es_emergencia === 1 ? `<td>Insumos utilizados: <br><b>${insumos}</b></td>` : ""}
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td>Indicaciones: <br><b>${indicaciones}</b></td>
                    <td>Referidos a otro médico: <br><b>${referidos}</b></td>
                </tr>
                <tr><td><br></td></tr>
                ${recipes}
                <tr><td><br></td></tr>
                <tr><td><br></td></tr>
                ${factura}
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add text-nowrap mb-3" href="#" onclick="openPopup('${data.es_emergencia == 0 ? "pdf/consulta/" + data.consulta_id : "pdf/presupuesto/" + data.consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a> <br> <button class="btn btn-sm btn-add mb-3" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg${tipo_cita}" onclick="pagarConsulta(${JSON.stringify({ citaType: tipo_cita, consulta_id: data.consulta_id, paciente_id: data.paciente_id }).replaceAll("\"", "'")})"><i class="fa-sm fas fa-plus"></i> Pagar consulta</button> <br> ${data.es_emergencia == 1 ? '<button class="btn btn-sm btn-add" id="btn-act" data-bs-toggle="modal" data-bs-target="#modalAct" onclick="updateConsulta(' + data.consulta_id + ')"><i class="fa-sm fas fa-plus"></i> Actualizar consulta</button>': ""}</td>
                </tr>
            </table>
        `
    }

    createDataTable({
        id: "#consultas",
        columns: consultasColumns,
        url: `/${path[1]}/consultas/consulta/`,
        // columnDefs: columnDefsConsultas,
        // searchPanes: searchPanesConsultas,
        order,
        format,
        formatDataCustom: true,
        formatDataCustomUrl: "consultas",
        formatDataCustomId: "consulta_id",
        // dom: "Plfrtip",
        serverSide: true,
        processing: true,

    });
});