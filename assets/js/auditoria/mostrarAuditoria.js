import { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

async function getAuditoria(type, form = null) {

    let url = "",
        body = {};


    if (type === "submenu-fecha") {
        url = "fecha";
        body = {
            fecha_inicio: form.fecha_inicio.value,
            fecha_fin: form.fecha_fin.value
        }
    } else if (type === "submenu-usuario") {
        url = `${form.usuario.value}`;
    } else if (type === "submenu-accion") {
        url = "accion";
        body = {
            accion: form.accion.value
        }
    } else if (type === "sinFiltro") {
        url = "getAll";
    } else {
        url = "getAll";
    }


    if (url !== "getAll") {

        const options = {
            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(body),
        };

        if (type === "submenu-usuario") {
            options.method = "GET";
            delete options.body;
        }

        let response = await fetch(`/${path[1]}/auditoria/${url}`, options),
            json = await response.json();

        return json;

    } else {

        const allAuditoria = {
            data: await getAll("auditoria/consulta")
        };

        return allAuditoria;
    }
}

async function filtrarAuditoria(e) {
    e.preventDefault();

    const $form = document.getElementById("filtrarPor"),
        inputFiltro = document.getElementById("inputFiltro");

    if (!inputFiltro.value) return;
    if (!$form.checkValidity()) { $form.reportValidity(); return; }

    const auditoriaInfo = await getAuditoria(inputFiltro.value, $form);

    $('#auditoria').DataTable().clear();
    $('#auditoria').DataTable().destroy();

    let auditoria = $('#auditoria').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        data: auditoriaInfo.data,
        columns: [

            { data: "auditoria_id" },
            { data: "nombre_usuario" },
            { data: "accion" },
            { data: "descripcion" },
            { data: "fecha_creacion" }
        ],
    });
}

window.filtrarAuditoria = filtrarAuditoria;

async function createAuditoria(onload = false) {

}

addEventListener("DOMContentLoaded", e => {

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

