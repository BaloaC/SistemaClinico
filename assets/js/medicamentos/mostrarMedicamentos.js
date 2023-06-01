import { select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
const path = location.pathname.split('/');

select2OnClick({
    selectSelector: "#s-especialidad",
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    module: "especialidades/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione una especialidad"
});

addEventListener("DOMContentLoaded", e => {

    const rol = Cookies.get("rol");

    let medicamentos = $('#medicamentos').DataTable({

        bAutoWidth: false,
        language: {
            url: `/${path[1]}/assets/libs/datatables/dataTables.spanish.json`
        },
        ajax: `/${path[1]}/medicamento/consulta/`,
        columns: [

            { data: "medicamento_id" },
            { data: "nombre_medicamento" },
            { data: "nombre_especialidad" },
            { 
                data: "tipo_medicamento",
                render: function(data, type, row){
                    if(data == 1) return "Cápsula";
                    if(data == 2) return "Jarabe";
                    if(data == 3) return "Inyección";
                }
            },
            {
                data: "medicamento_id",
                render: function (data, type, row) {
                    // console.log(data);
                    switch(rol){

                        case "1": return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-medicamento" onclick="updateMedicamento(${data})"><i class="fas fa-edit act-medicamento"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-medicamento" onclick="deleteMedicamento(${data})"><i class="fas fa-trash del-medicamento"></i></a>
                        `;
                    
                        case "2": return `
                        <a class="act-medicamento"><i class="fas fa-edit disabled act-medicamento"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-medicamento" onclick="deleteMedicamento(${data})"><i class="fas fa-trash del-medicamento"></i></a>
                        `;

                        default: return `
                        <a class="act-medicamento"><i class="fas fa-edit disabled act-medicamento"></i></a>
                        <a class="del-medicamento"><i class="fas fa-trash disabled del-medicamento"></i></a>
                        `;
                    }

                    // return `
                    //     <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-especialidad" onclick="deleteMedicamento(${data})"><i class="fas fa-trash del-insumo"></i></a>
                    // `
                }
            }

        ],
        columnDefs: [{
            searchPanes: {
                show: true,
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

