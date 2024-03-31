import { select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";
const path = location.pathname.split('/');

// select2OnClick({
//     selectSelector: "#s-especialidad",
//     selectValue: "especialidad_id",
//     selectNames: ["nombre"],
//     module: "especialidades/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione una especialidad"
// });

addEventListener("DOMContentLoaded", e => {

    const rol = Cookies.get("rol");

    // Para permitir que se filtre con la fecha formateada
    $.fn.dataTable.moment('DD-MM-YYYY');

    const usuariosColumns = [

        { data: "nombre" },
        {
            data: "rol",
            render: function (data, type, row) {
                if (data == 1) return "Administrador";
                if (data == 2) return "Gerente";
                if (data == 3) return "Contador";
                if (data == 4) return "Analista";
                if (data == 5) return "Facultativo de salud";
            }
        },
        {
            data: "fecha_creacion",
            render: function (data, type, row) {
                return formatToRealDate(data);
            }
        },
        {
            data: "usuario_id",
            render: function (data, type, row) {
                switch (rol) {

                    case "1": return `
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-usuario" onclick="updateUsuario(${data})"><i class="fas fa-edit act-usuario"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a>
                    `;

                    case "2": return `
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a>
                    `;

                    default: return `-`;
                }
            }
        }

    ];
    const order = [[2, 'desc']];
    const columnDefsUsuarios = [
        {
            searchPanes: {
                show: false,
            },
            targets: [2, 3],
        },
        {
            type: 'datetime-moment',
            targets: 3
        }
    ];
    const searchPanesUsuarios = {
        controls: false,
        hideCount: true,
        collapse: true,
        initCollapsed: true
    };

    createDataTable({
        id: "#usuariosTable",
        url: `/${path[1]}/usuarios/consulta/`,
        columns: usuariosColumns,
        order,
        columnDefs: columnDefsUsuarios,
        searchPanes: searchPanesUsuarios,
        dom: "Plfrtip"
    });
});

