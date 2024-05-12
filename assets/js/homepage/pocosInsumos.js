import getAll from "../global/getAll.js";

const path = location.pathname.split('/');

$(document).ready(async function () {

    const insumosList = await getAll("insumos/consulta");

    const insumosPorAgotarse = (insumosList?.result && !insumosList?.result?.code) ? [] : insumosList.filter(insumos => insumos.cantidad < insumos.cantidad_min);

    console.log(insumosPorAgotarse);

    let tabla = $('#pocosInsumos').DataTable({
        data: insumosPorAgotarse ?? [],
        columns: [
            {
                data: "nombre"
            },
            {
                data: "cantidad_min"
            },
            {
                data: "cantidad",

                render: function (data, type, row) {
                    if (row.estatus_ins === "3") {
                        return `<span class="badge light badge-success">Recién agregado</span>`;
                    } else {
                        return row.cantidad;
                    }
                },
            }
        ],
        pageLength: 10,
        lengthChange: false,
        searching: false,
        order: [[2, "asc"]],
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
        deferLoading: 0
    });

    // Ocultar paginación
    document.getElementById("pocosInsumos_paginate").classList.add("d-none");
});