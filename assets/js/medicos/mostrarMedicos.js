import { select2OnClick } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import getAll from "../global/getAll.js";
import concatItems from "../global/concatItems.js";
import { removeAddAnalist } from "../global/validateRol.js";
removeAddAnalist();
async function getMedico(id) {
    try {

        const $nombreMedico = document.getElementById("nombreMedico"),
            $cedulaMedico = document.getElementById("cedulaMedico"),
            $nombresMedico = document.getElementById("nombresMedico"),
            $apellidosMedico = document.getElementById("apellidosMedico"),
            $tlfMedico = document.getElementById("tlfMedico"),
            $direcMedico = document.getElementById("direcMedico"),
            $especialidadMedico = document.getElementById("especialidadMedico"),
            $horarioMedico = document.getElementById("horarioMedico"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");
        let horario = "";
        let especialidad = "";

        const json = await getById("medicos/", id);

        json[0].horario.forEach(el => {
            horario += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.horario_id}" ${json[0].horario.length > 1
                    ? `onclick=(deleteHorario(${el.horario_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                    : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    <i class="fa-sm fas fa-times"></i> 
                    ${el.dias_semana}
                </button>
            `;
        });

        $horarioMedico.innerHTML = horario;

        json[0].especialidad.forEach(el => {
            especialidad += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.medico_especialidad_id}" ${json[0].especialidad.length > 1
                    ? `onclick=(deleteEspecialidad(${el.medico_especialidad_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                    : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    <i class="fa-sm fas fa-times"></i> 
                    ${el.nombre_especialidad}
                </button>
            `;
        });

        $especialidadMedico.innerHTML = especialidad;

        $nombreMedico.innerText = `${json[0].nombre.split(" ")[0]} ${json[0].apellidos.split(" ")[0]}`;
        $cedulaMedico.innerText = `C.I: ${json[0].cedula}`;
        $nombresMedico.innerText = `${json[0].nombre}`;
        $apellidosMedico.innerText = `${json[0].apellidos}`;
        $tlfMedico.innerText = `${json[0].telefono}`;
        $direcMedico.innerText = `${json[0].direccion}`;
        $btnActualizar.setAttribute("onclick", `updateMedico(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteMedico(${id})`);

    } catch (error) {

        alert(error);
    }
}

window.getMedico = getMedico;

export async function mostrarMedicos() {

    // try {

    //     const listadoMedicos = await getAll("medicos/consulta"),
    //         $cardTemplate = document.getElementById("card-template").content,
    //         $medicosContainer = document.getElementById("medicos-container"),
    //         $fragment = document.createDocumentFragment();

    //     listadoMedicos.forEach(el => {

    //         let $nombreMedico = $cardTemplate.querySelector("h3"),
    //             $cardContainer = $cardTemplate.querySelector(".card-container"),
    //             $cedula = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
    //             $especialidad = $cardTemplate.querySelector(".list-group > li:nth-child(2) > b"),
    //             $telefono = $cardTemplate.querySelector(".list-group > li:nth-child(3) > b");


    //         $nombreMedico.textContent = `${el.nombre.split(" ")[0]} ${el.apellidos.split(" ")[0]}`;
    //         $cedula.textContent = el.cedula;
    //         $especialidad.textContent = el.especialidad !== undefined ? concatItems(el.especialidad, "nombre_especialidad", "No posee ninguna especialidad") : "No posee ninguna especialidad";
    //         $telefono.textContent = el.telefono;
    //         $cardContainer.setAttribute("onclick", `getMedico(${el.medico_id})`);

    //         let clone = document.importNode($cardTemplate, true);
    //         $fragment.appendChild(clone);
    //     })

    //     $medicosContainer.replaceChildren();
    //     $medicosContainer.appendChild($fragment);

    // } catch (error) {
    //     console.log(error);
    // }
}

// document.addEventListener("DOMContentLoaded", e => {
//     mostrarMedicos();
// });


select2OnClick({
    selectSelector: "#s-especialidad",
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    module: "especialidades/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione una especialidad",
    multiple: true
});