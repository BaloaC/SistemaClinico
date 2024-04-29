import createDataTable from "../global/createDataTable.js";

const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", () => {

    const insumosColumns = [
        { data: "insumo_id" },
        { data: "nombre" },
        { data: "cantidad" },
        { data: "cantidad_min" },
        { data: "cantidad_unidad" },
        { data: "capacidad_unidad" },
        { 
            data: "tipo_medida",
            render: function(data){

                console.log(data);

                switch(data){
                    case "1": return "Rollo";
                    case "2": return "Botella";
                    case "3": return "Caja";
                    case "4": return "Unidad";
                }
            }
        },
        { 
            data: "es_cobrado",
            render: function(data){

                console.log(data);

                switch(data){
                    case "1": return "Sí";
                    case "2": return "No";
                    default: return "No"
                }
            }
        },
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