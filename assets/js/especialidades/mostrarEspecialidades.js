const path = location.pathname.split('/');

addEventListener("DOMContentLoaded", e => {

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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-especialidad" onclick="updateEspecialidad(${data})"><i class="fas fa-edit act-especialidad"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-especialidad" onclick="deleteEspecialidad(${data})"><i class="fas fa-trash del-especialidad"></i></a>
                    `
                }
            }

        ]
    });

});

