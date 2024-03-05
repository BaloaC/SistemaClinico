import { select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
const path = location.pathname.split('/');

// select2OnClick({
//     selectSelector: "#s-especialidad",
//     selectValue: "especialidad_id",
//     selectNames: ["nombre"],
//     module: "especialidades/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione una especialidad"
// });

addEventListener("DOMContentLoaded", e => {

    const rol = Cookies.get("rol");

    let usuarios = $('#usuariosTable').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: {
            url: `/${path[1]}/usuarios/consulta/`,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + Cookies.get("tokken"));
            },
            error: function(xhr, error, thrown) {
                // Manejo de errores de Ajax
                console.log('Error de Ajax:', error);
                console.log('Detalles:', thrown);

                $('#usuariosTable').DataTable().clear().draw();
            }
        },
        columns: [

            { data: "nombre" },
            { 
                data: "rol",
                render: function(data, type, row){
                    if(data == 1) return "Administrador";
                    if(data == 2) return "Gerente";
                    if(data == 3) return "Contador";
                    if(data == 4) return "Analista";
                    if(data == 5) return "Facultativo de salud";
                }
            },
            { data: "fecha_creacion" },
            {
                data: "usuario_id",
                render: function (data, type, row) {
                    switch(rol){

                        case "1": return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-usuario" onclick="updateUsuario(${data})"><i class="fas fa-edit act-usuario"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a>
                        `;
                    
                        case "2": return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-usuario" onclick="deleteUsuario(${data})"><i class="fas fa-trash del-usuario"></i></a>
                        `;

                        default: return `-`;
                    }
                }
            }

        ],
        columnDefs: [{
            searchPanes: {
                show: false,
            },
            targets: [2,3],
        }],
        // ! rowData (Devuelve toda la fila)
        searchPanes: {
            controls: false,
            hideCount: true,
            collapse: true,
            initCollapsed: true
        },
        dom: 'Plfrtip'
    });
});

