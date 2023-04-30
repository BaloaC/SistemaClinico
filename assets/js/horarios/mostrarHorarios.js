const d = document,
    path = location.pathname.split('/');

d.addEventListener("DOMContentLoaded", e => {

    let horarios = $('#horarios').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/horarios/consulta/`,
        columns: [

            { data: "horario_id" },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "dias_semana" },
            {
                data: "horario_id",
                render: function (data, type, row) {

                    return `
                        <a href="#" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-especialidad"><i class="fas fa-edit act-especialidad" data-id="${data}"></i></a>
                    `
                }
            }

        ],
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [0, 1, 2, 3],
        }],
        searchPanes: {
            controls: false,
            hideCount: true,
            collapse: true,
            initCollapsed: true,
            panes: [
                {
                    header: 'Filtrar por día:',
                    options: [
                        {
                            label: 'Lunes',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "lunes";
                            },
                            className: 'horario-lunes'
                        },
                        {
                            label: 'Martes',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "martes";
                            },
                            className: 'horario-martes'
                        },
                        {
                            label: 'Miércoles',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "miercoles";
                            },
                            className: 'horario-miercoles'
                        },
                        {
                            label: 'Jueves',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "jueves";
                            },
                            className: 'horario-jueves'
                        },
                        {
                            label: 'Viernes',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "viernes";
                            },
                            className: 'horario-viernes'
                        },
                        {
                            label: 'Sábado',
                            value: function (rowData, rowIdx) {
                                return rowData.dias_semana === "sabado";
                            },
                            className: 'horario-sabado'
                        }
                    ],
                    dtOpts: {
                        searching: false,
                        order: [[1, 'desc']]
                    }
                }
            ]
        },
        dom: 'Plfrtip'
    });

});
