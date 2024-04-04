const path = location.pathname.split('/');
import createDataTable from "../global/createDataTable.js";
import { removeAddAnalist,removeAddMD } from "../global/validateRol.js";


addEventListener("DOMContentLoaded", () => {

    removeAddAnalist();
    removeAddMD();

    const especialidadesColumns = [
        { data: "especialidad_id" },
        { data: "nombre" },
        {
            data: "especialidad_id",
            render: function (data, type, row) {

                // TODO: Filtrar opciones por rol
                return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-especialidad" onclick="updateEspecialidad(${data})"><i class="fas fa-edit act-especialidad"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-especialidad" onclick="deleteEspecialidad(${data})"><i class="fas fa-trash del-especialidad"></i></a>
                    `
            }
        }

    ];

    createDataTable({
        id: "#especialidades",
        columns: especialidadesColumns,
        url: `/${path[1]}/especialidades/consulta/`,
        processing: true,
        serverSide: true
    });
});