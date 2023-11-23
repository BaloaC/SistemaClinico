const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import { removeAddAnalist,removeAddMD } from "../global/validateRol.js";


addEventListener("DOMContentLoaded", e => {
    removeAddAnalist(); removeAddMD();
    let especialidades = $('#especialidades').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url :`/${path[1]}/especialidades/consulta/`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function(xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);

                $('#especialidades').DataTable().clear().draw();
            }
        },
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

