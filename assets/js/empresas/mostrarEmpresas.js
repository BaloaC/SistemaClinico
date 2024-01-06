import concatItems from "../global/concatItems.js";
import { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";

async function getEmpresa(id) {
    try {

        const $nombreEmpresa = document.getElementById("nombreEmpresa"),
            $rifEmpresa = document.getElementById("rifEmpresa"),
            $nombreSeguro = document.getElementById("nombreSeguro"),
            $direcEmpresa = document.getElementById("direcEmpresa"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");

        const json = await getById("empresas/", id);
        let seguros = "";

        $nombreEmpresa.innerText = `${json.nombre}`;
        $rifEmpresa.innerText = `${json.rif}`;
        $direcEmpresa.innerText = `${json.direccion}`;


        json.seguro.forEach(el => {
            seguros += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.seguro_empresa_id}" ${json.seguro.length > 1
                    ? `onclick=(deleteSeguroEmpresa(${el.seguro_empresa_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteSeguro"`
                    : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    ${el.nombre}
                    <i class="fa-sm fas fa-times"></i> 
                </button>
            `;
        });

        $nombreSeguro.innerHTML = seguros;


        // $nombreSeguro.innerText = `${json[0].nombre}`;
        $btnActualizar.setAttribute("onclick", `updateEmpresa(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteEmpresa(${id})`);

    } catch (error) {

        alert(error);
    }
}

window.getEmpresa = getEmpresa;

select2OnClick({
    selectSelector: "#s-seguro",
    selectValue: "seguro_id",
    selectNames: ["rif", "nombre"],
    module: "seguros/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un seguro",
    selectWidth: "100%"
});