const d = document,
    path = location.pathname.split('/');

d.addEventListener("DOMContentLoaded", e => {

    let especialidades = $('#especialidades').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/especialidades/consulta/`,
        columns: [

            { data: "especialidad_id" },
            { data: "nombre" },
            {
                data: "especialidad_id",
                render: function (data, type, row) {

                    return `
                        <a href="#" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-especialidad"><i class="fas fa-edit act-especialidad" data-id="${data}"></i></a>
                    `
                }
            }

        ]
    });

});

