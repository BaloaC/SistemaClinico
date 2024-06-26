import { select2OnClick } from "../global/dinamicSelect2.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import { removeAddMD } from "../global/validateRol.js";
import createDataTable from "../global/createDataTable.js";
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

    // Remover el boton de añadir dependiendo el rol
    removeAddMD();

    const rol = Cookies.get("rol");

    const medicamentosColumns = [

        { data: "medicamento_id" },
        { data: "nombre_medicamento" },
        { data: "nombre_especialidad" },
        {
            data: "tipo_medicamento",
            render: function (data, type, row) {
                if (data == 1) return "Cápsula";
                if (data == 2) return "Jarabe";
                if (data == 3) return "Inyección";
                if (data == 4) return "Solución";
                if (data == 5) return "Gotas";
                if (data == 6) return "Crema/Loción";
            }
        },
        {
            data: "medicamento_id",
            render: function (data, type, row) {
                switch (rol) {

                    case "1": return `
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-medicamento" onclick="updateMedicamento(${data})"><i class="fas fa-edit act-medicamento"></i></a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-medicamento" onclick="deleteMedicamento(${data})"><i class="fas fa-trash del-medicamento"></i></a>
                        `;
                        
                    default: return `-`;
                }
            },
            visible: (rol !== "1") ? false: true
        }
    ];

    const columnDefsMedicamentos = [{
        searchPanes: {
            show: true,
        },
        targets: [2, 3],
    }];

    const searchPanesMedicamentos = {
        controls: false,
        hideCount: true,
        collapse: true,
        initCollapsed: true
    };

    createDataTable({
        id: "#medicamentos",
        columns: medicamentosColumns,
        url: `/${path[1]}/medicamento/consulta/`,
        // columnDefs: columnDefsMedicamentos,
        // searchPanes: searchPanesMedicamentos,
        // dom: "Plfrtip",
        processing: true,
        serverSide: true
    });
});

