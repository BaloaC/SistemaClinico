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

    const $form = document.getElementById("filtrarPor");
    const formData = new FormData($form),
        data = {};

    formData.forEach((value, key) => (data[key] = value));

    console.log(data);
    if (!$form.checkValidity()) { $form.reportValidity(); return; }
    // if(data?.fecha_inicio )


    let auditoriaUrl = "";

    if(data.usuario_id) auditoriaUrl += `?usuario_id=${data.usuario_id}`;
    if(data.accionValue) auditoriaUrl += `&accion=${data.accionValue}`;
    if(data.moduloValue) auditoriaUrl += `&modulo="${data.moduloValue}"`;
    if(data.fecha_inicio) auditoriaUrl += `&fecha_inicio=${data.fecha_inicio}&fecha_fin=${data.fecha_fin}`;   

    document.getElementById("btn-exportarPdf").setAttribute("onclick",`openPopup('pdf/auditoria/00001${auditoriaUrl}')`);

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
        url: `/${path[1]}/auditoria/consulta${auditoriaUrl}`,
        serverSide: true,
        processing: true,
        order: [[4, 'desc']]
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

