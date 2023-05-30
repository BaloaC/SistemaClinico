$(document).ready(function() {
    let tabla = $('#pocosInsumos').DataTable({
        ajax: "http://127.0.0.1/proyectoFEO/insumos/consulta/",
        columns: [
            {
                data: "insumo_id"
            },
            {
                data: "nombre"
            },
            {
                data: "cantidad"
            },
        ],
        pageLength: 10,
        lengthChange: false,
        searching: false,
        order: [[2,"asc"]],
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
    });

    // Ocultar paginación
    document.getElementById("pocosInsumos_paginate").classList.add("d-none");
});