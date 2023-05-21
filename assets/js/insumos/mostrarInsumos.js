const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", e => {

    let insumos = $('#insumos').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/insumos/consulta/`,
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

