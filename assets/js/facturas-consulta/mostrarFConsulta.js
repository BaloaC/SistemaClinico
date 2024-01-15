import dinamicSelect2, { emptyAllSelect2, emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

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

        const empresaSelect = document.getElementById(modalParent === "#modalReg" ? "s-empresa" : "s-empresa-act");
        const seguroSelect = modalParent === "#modalReg" ? "#s-seguro" : "#s-seguro-act";
        const segurosList = await getAll("seguros/consulta");

        const pacientesList = await getAll("pacientes/consulta");

        dinamicSelect2({
            obj: pacientesList,
            selectSelector: "#s-paciente-consulta",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalRegNormal",
            placeholder: "Seleccione un paciente"
        });

        $("#s-paciente-consulta").val([]).trigger("change")
        document.getElementById("s-paciente-consulta").classList.remove("is-valid");

        $("#s-paciente-consulta").on("change", async function () {

            let paciente_id = this.value;
            const infoConsultas = await getById("consultas/paciente", paciente_id);

            $("#s-consulta-normal").empty().select2();

            console.log(infoConsultas);

            dinamicSelect2({
                obj: infoConsultas?.consultas ?? [],
                selectSelector: `#s-consulta-normal`,
                selectValue: "consulta_id",
                selectNames: ["consulta_id", "motivo_cita"],
                parentModal: "#modalRegNormal",
                placeholder: "Seleccione una consulta",
                defaultLabel: ["Consulta por emergencia"]
            });


            const consultaSelect = document.getElementById("s-consulta-normal");
            consultaSelect.disabled = false;
            consultaSelect.classList.add("is-valid");
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

    let fConsulta = $('#fConsulta').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/factura/consulta/consulta/`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function (xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);

                $('#fConsulta').DataTable().clear().draw();
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
                    return `${row.monto_consulta_bs} Bs`;
                }
            },
            {
                data: function (row) {
                    return `$${row.monto_consulta_usd}`;
                }
            },
            {
                data: function (row) {
                    return row.fecha_consulta;
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
            // {
            //     data: null,
            //     render: function (data, type, row) {
            //         // <a href="#" data-bs-toggle="modal" data-bs-target="#modalInfo" class="view-info" onclick="getPaciente(${data})"><i class="fas fa-eye view-info""></i></a>
            //         if (row.estatus_fac == 1) {
            //             return `
            //                 <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-paciente" onclick="deleteFConsulta(${row.estatus_fac})"><i class="fas fa-trash del-consulta"></i></a>
            //             `
            //         } else {
            //             return `-`;
            //         }
            //     }
            // }

        ],
        order: [[5, 'desc']]
    });

    function format(data) {

        return `
            <table cellpadding="5" cellspacing="0" border="0" style=" padding-left:50px; width: 100%">
                <tr>
                    <td colspan="4"><b>Información consulta:</b></td>
                </tr>
                <tr>
                    <td>Nombre médico: <br><b>${data?.nombre_medico ? data?.nombre_medico + " " + data?.apellidos_medico : "Desconocido"}</b></td>
                    <td>Especialidad: <br><b>${data?.nombre_especialidad ?? "Desconocido"}</b></td>
                    <td>Monto consulta BS: <br><b>${data?.monto_consulta_bs ?? "Desconocido"} Bs</b></td>
                    <td>Monto consulta USD: <br><b>$${data?.monto_consulta_usd ?? "Desconocido"}</b></td>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <td><a class="btn btn-sm btn-add" href="#" onclick="openPopup('pdf/facturaconsulta/${data.factura_consulta_id}')"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a></td>
                </tr>
            </table>
        `;
    }

    $('#fConsulta').on('click', 'td.dt-control', function () {
        let tr = $(this).closest('tr');
        let row = fConsulta.row(tr);

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


