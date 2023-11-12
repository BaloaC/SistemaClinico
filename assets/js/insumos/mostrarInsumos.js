import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", e => {

    let insumos = $('#insumos').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/insumos/consulta/`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function(xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);
            }
        },
        columns: [

            { data: "insumo_id" },
            { data: "nombre" },
            { data: "cantidad" },
            { data: "cantidad_min" },
            { data: "precio" },
            {
                data: "insumo_id",
                render: function (data, type, row) {

                    return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-especialidad" onclick="deleteInsumo(${data})"><i class="fas fa-trash del-insumo"></i></a>
                    `
                }
            }

        ]
    });
});

