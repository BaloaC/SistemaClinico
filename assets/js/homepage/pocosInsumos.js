$(document).ready(function() {
    let tabla = $('#pocosInsumos').DataTable({
        pageLength: 5,
        lengthChange: false,
        searching: false,
        order: [[1,"asc"]],
        language: {
            "decimal": ",",
            "thousands": ".",
            "info": "Mostrando registros del _START_ al _END_ de _MAX_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de 0 registros",
            "infoPostFix": "",
            "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "processing": "Procesando...",
            "search": "Buscar registro:",
            "searchPlaceholder": "Buscar...",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Sin datos guardados",
        },
        bAutoWidth: false,
        // ajax: "http://127.0.0.1/proyectofeo/usuarios/consulta/",
        // columns: [{
        //         data: "usuario_id"
        //     },
        //     {
        //         data: "clave",
        //         render: function(data) {
        //             return `<span class="badge-danger">${data}</span>`;
        //         }
        //     }
        // ],
    });
});