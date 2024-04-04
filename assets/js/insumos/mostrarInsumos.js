import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", () => {

    const insumosColumns = [
        { data: "insumo_id" },
        { data: "nombre" },
        { data: "cantidad" },
        { data: "cantidad_min" },
        {
            data: "precio",
            render: function (data, type, row) {
                return `$${data}`;
            }
        },
        {
            data: "insumo_id",
            render: function (data, type, row) {

                return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-especialidad" onclick="deleteInsumo(${data})"><i class="fas fa-trash del-insumo"></i></a>
                    `
            }
        }
    ];

    createDataTable({
        id: "#insumos",
        url: `/${path[1]}/insumos/consulta/`,
        columns: insumosColumns,
        processing: true,
        serverSide: true
    });
});