import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import convertCurrencyToVES from "../global/convertCurrencyToVES.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";
import concatItems from "../global/concatItems.js";

const path = location.pathname.split('/');


let modalOpened = false;
const modalRegister = document.getElementById("modalRegNormal") ?? undefined;

const handleModalOpen = async (modalParent) => {
    if (modalOpened === false) {

        emptyAllSelect2({
            selectSelector: "#s-paciente-consulta",
            parentModal: modalParent,
            placeholder: "Cargando"
        })

        emptyAllSelect2({
            selectSelector: "#s-consulta-normal",
            parentModal: modalParent,
            placeholder: "Debe seleccionar un paciente"
        })

        dinamicSelect2({
            selectSelector: "#s-paciente-consulta",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalRegNormal",
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
        });

        $("#s-paciente-consulta").val([]).trigger("change")
        document.getElementById("s-paciente-consulta").classList.remove("is-valid");

        $("#s-paciente-consulta").on("change", async function () {

            let paciente_id = this.value;
            const consultasAseguradas = await getAll(`consultas/paciente/${paciente_id}?tipo_cita=2&status=4`);

            $("#s-consulta-normal").empty().select2();
            
            dinamicSelect2({
                selectSelector: `#s-consulta-normal`,
                selectValue: "consulta_id",
                selectNames: ["consulta_id", "motivo_cita"],
                parentModal: "#modalRegNormal",
                placeholder: "Seleccione una consulta",
                defaultLabel: ["Consulta por emergencia"],
                ajax: true,
                ajaxUrl: `consultas/paciente/${paciente_id}?emergencia=1`,
                processResultsAjax: function (data, params) { 

                    const data1 = [];

                    if (typeof data === "object" && data?.data?.consultas !== 0) {
                        data?.data?.consultas?.forEach(object => {
                            
                            const { consulta_id: valorPropiedad1, observaciones } = object;
                            
                            data1.push({ id: valorPropiedad1, text: `${valorPropiedad1} - ${observaciones ?? "Sin observaciones"}` });
                        });
                    }

                    if (typeof consultasAseguradas === "object" && consultasAseguradas?.consultas.length !== 0) {
                        consultasAseguradas?.consultas?.forEach(object => {
                            
                            const { consulta_id: valorPropiedad1, es_emergencia, observaciones } = object;
                            let consultaText = es_emergencia == 1 && observaciones ? "Consulta por emergencia" : (observaciones ?? "Consulta asegurada");

                            data1.push({ id: valorPropiedad1, text: `${valorPropiedad1} - ${consultaText}` });
                        });
                    }

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1 ?? []
                    };
                }

                
            });


            const consultaSelect = document.getElementById("s-consulta-normal");
            consultaSelect.disabled = false;
            consultaSelect.classList.add("is-valid");

            $("#s-consulta-normal").on("change", async function(){

                const infoConsultaAsegurada = await getAll(`factura/consultaSeguro/consulta/${this.value}`);

                if(infoConsultaAsegurada !== null){
                    document.getElementById("monto_consulta_usd_consulta").value = parseFloat(infoConsultaAsegurada.monto_total_usd) - parseFloat(infoConsultaAsegurada.cobertura_seguro);
                }

            })
        });

        dinamicSelect2({
            obj: [{ id: "efectivo", text: "Efectivo" }, { id: "debito", text: "Debito" }],
            selectNames: ["text"],
            selectValue: "id",
            selectSelector: "#s-metodo-pago",
            placeholder: "Seleccione un método de pago",
            parentModal: "#modalRegNormal",
            staticSelect: true
        });


        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegNormal"));


addEventListener("DOMContentLoaded", e => {

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const fConsultaColumns = [
        {
            "className": 'dt-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        {data: "factura_consulta_id"},
        {
            data: function (row) {
                return `${row.nombre_paciente} ${row.apellidos}` ?? `Consulta por emergercia`;
            }
        },
        {
            data: function (row) {
                return row.metodo_pago;
            }
        },
        {
            data: function (row) {
                return `${convertCurrencyToVES(row.monto_total_bs ?? 0)} Bs`;
            }
        },
        {
            data: function (row) {
                return `$${row.monto_total_usd ?? 0}`;
            }
        },
        {
            data: function (row) {
                return formatToRealDate(row.fecha_consulta);
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                if (row.estatus_fac == 1) {
                    return `<span class="badge light badge-success">Pagada</span>`;
                } else {
                    return `<span class="badge light badge-danger">Anulada</span>`;
                }
            },
        },
    ];

    const columnDefsFConsulta = [{
        type: 'datetime-moment',
        targets: 6
    }];

    const order = [[5, 'desc']];

    const format = (data) => {

        let cita_examenes = data?.cita_examenes !== undefined ? concatItems(data.cita_examenes, "nombre", "No se realizó a ningún exámen por cita", ".") : "No se realizó a ningún exámen por cita";
        let examenes = data?.examenes !== undefined ? concatItems(data.examenes, "nombre", "No se realizó ningún exámen") : "No se realizó ningún exámen",
            insumos = data?.insumos !== undefined ? concatItems(data?.insumos, "nombre", "No se utilizó ningún insumo") : "No se utilizó ningún insumo",
            indicaciones = data?.indicaciones !== undefined ? concatItems(data.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación",
            referidos = data?.referidos !== undefined ? concatItems(data.referidos, "nombre", "No se refirió a ningún médico", ".") : "No se refirió a ningún médico";

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px;>
                <tr>
                    <td colspan="4"><b>Información consulta:</b></td>
                </tr>
                <tr>
                    <td class="py-3 pe-3">Nombre médico: <br><b>${data?.nombre_medico ? data?.nombre_medico + " " + data?.apellidos_medico : "Desconocido"}</b></td>
                    <td class="py-3 pe-3">Especialidad: <br><b>${data?.nombre_especialidad ?? "Desconocido"}</b></td>
                    ${!data.consulta_seguro_id ? `
                        <td class="py-3 pe-3">Monto consulta BS: <br><b>${data?.monto_consulta_bs ?? "Desconocido"} Bs</b></td>
                        <td class="py-3 pe-3">Monto consulta USD: <br><b>$${data?.monto_consulta_usd ?? "Desconocido"}</b></td>
                    ` : ""}
                   
                </tr>
                <tr>
                    ${examenes !== "No se realizó ningún exámen" ? `<td class="py-3">Exámenes realizados: <br><b>${examenes}</b></td>` : ""}
                    ${data.es_emergencia == true && insumos !== "No se utilizó ningún insumo" ? `<td class="py-3">Insumos utilizados: <br><b>${insumos}</b></td>` : ""}
                    ${cita_examenes !== "No se realizó a ningún exámen por cita" ? `<td class="py-3">Exámenes por citas: <br><b>${cita_examenes}</b></td>` : ""} 
                </tr>
                <tr>
                    ${indicaciones !== "No se realizó ninguna indicación" ? `<td class="py-3">Indicaciones: <br><b>${indicaciones}</b></td>` : ""}
                    ${referidos !== "No se refirió a ningún médico" ? `<td class="py-3">Referidos a otro médico: <br><b>${referidos}</b></td>` : ""} 
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturaconsulta/${data.factura_consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
                </tr>
            </table>
        `;
    };

    createDataTable({
        id: "#fConsulta",
        url: `/${path[1]}/factura/consulta/consulta/`,
        columns: fConsultaColumns,
        columnDefs: columnDefsFConsulta,
        order,
        format,
        formatDataCustom: true,
        formatDataCustomUrl: "factura/consulta",
        formatDataCustomId: "factura_consulta_id",
        processing: true,
        serverSide: true
    });
});