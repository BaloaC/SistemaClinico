import Cookies from "../../libs/jscookie/js.cookie.min.js";
import formatToRealDate from "../global/formatToRealDate.js";
import createDataTable from "../global/createDataTable.js";
const path = location.pathname.split('/');

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
            data: "estatus_usu",
            render: function (data, type, row) {
                return `
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalActEstatus" onclick="actualizarEstatusUsuario(${row.usuario_id},'${data}', false)">${row.estatus_usu == 2 ? "<span class='badge light badge-warning'>Inactivo</span>" : "<span class='badge light badge-success'>Activo</span>"}</a>
                `;
            },
        },
        {
            data: "usuario_id",
            render: function (data, type, row) {
                {/* <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a> */ }
                switch (rol) {
                    case "1": return `
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-usuario" onclick="updateUsuario(${data})"><i class="fas fa-edit act-usuario"></i></a>
                    
                    `;

                    case "2": return `
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a>
                    `;

                    default: return ` `;
                }
            },
            visible: rol !== "1" && rol !== "2" ? false : true
        }

    ];
    const order = [[2, 'desc']];

    createDataTable({
        id: "#usuariosTable",
        url: `/${path[1]}/usuarios/consulta/`,
        columns: usuariosColumns,
        order,
        processing: true,
        serverSide: true
    });
});

