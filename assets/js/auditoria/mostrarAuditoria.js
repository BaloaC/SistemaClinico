import { select2OnClick } from "../global/dinamicSelect2.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

function getAuditoria(type, form = null) {
    const auditoria = {
        "submenu-fecha": {
            url: "fecha",
            body: {
                fecha_inicio: form?.fecha_inicio?.value,
                fecha_fin: form?.fecha_fin?.value
            }
        },
        "submenu-usuario": {
            url: `${form?.usuario?.value}`
        },
        "submenu-accion": {
            url: "accion",
            body: {
                accion: form?.accion?.value
            }
        },
        "sinFiltro": {
            url: "consulta"
        },
        default: {
            url: "consulta"
        }
    };

    return auditoria[type] ?? auditoria.default;
}

async function filtrarAuditoria(e) {
    e.preventDefault();

    const $form = document.getElementById("filtrarPor"),
        inputFiltro = document.getElementById("inputFiltro");

    if (!inputFiltro.value) return;
    if (!$form.checkValidity()) { $form.reportValidity(); return; }

    const auditoriaInfo = getAuditoria(inputFiltro.value, $form);

    $('#auditoria').DataTable().clear();
    $('#auditoria').DataTable().destroy();

    const auditoriaColumns = [
        { data: "auditoria_id" },
        { data: "nombre_usuario" },
        { data: "accion" },
        { data: "descripcion" },
        { data: "fecha_creacion" }
    ];
    createDataTable({
        id: "#auditoria",
        columns: auditoriaColumns,
        url: `/${path[1]}/auditoria/${auditoriaInfo.url}`,
        serverSide: true,
        processing: true,
        order: [[4, 'desc']],
        requestData: auditoriaInfo.body
    });
}

window.filtrarAuditoria = filtrarAuditoria;

addEventListener("DOMContentLoaded", () => {

    const auditoriaColumns = [
        { data: "auditoria_id" },
        { data: "nombre_usuario" },
        { data: "accion" },
        { data: "descripcion" },
        { data: "fecha_creacion" }
    ];

    createDataTable({
        id: "#auditoria",
        columns: auditoriaColumns,
        url: `/${path[1]}/auditoria/consulta/`,
        serverSide: true,
        processing: true,
        order: [[4, 'desc']]
    });

    select2OnClick({
        selectSelector: "#s-usuario",
        selectValue: "usuario_id",
        selectNames: ["nombre"],
        module: "usuarios/consulta",
        placeholder: "Selecciona un usuario"
    });
});

