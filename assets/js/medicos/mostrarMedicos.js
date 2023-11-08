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
            $horarioMedico = document.querySelector("#horarios-table tbody"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");
        let horario = "";
        let especialidad = "";

        const json = await getById("medicos/", id);

        if (json[0].horario?.length >= 1) {

            document.getElementById('info-medicos')?.remove();
            
            $("#horarioMessage").fadeOut("slow");
            $("#horarios-table").fadeIn("slow");

            json[0].horario.forEach(el => {
                horario += `
                    <tr>
                        <td>${el.dias_semana}</td>
                        <td>${el.hora_entrada}</td>
                        <td>${el.hora_salida}</td>
                        <td>
                            <button class="btn btn-sm btn-empresa" id="btn-add" value="asdas${el.horario_id}" ${json[0].horario.length >= 1
                        ? `onclick=(deleteHorario(${el.horario_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                        : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                                <i class="fa-sm fas fa-times m-0"></i> 
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            $("#horarioMessage").fadeIn("slow");
            $("#horarios-table").fadeOut("slow");
        }

        $horarioMedico.innerHTML = horario;


        if (json[0].especialidad?.length >= 1) {

            json[0].especialidad.forEach(el => {
                especialidad += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.medico_especialidad_id}" ${json[0].especialidad.length > 1
                        ? `onclick=(deleteEspecialidad(${el.medico_especialidad_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                        : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    ${el.nombre_especialidad}
                    <i class="fa-sm fas fa-times"></i> 
                </button>
            `;
            });

            $especialidadMedico.innerHTML = especialidad;

        } else {

            $especialidadMedico.innerHTML = "Este médico no posee ninguna especialidad";
        }

        

        $nombreMedico.innerText = `${json[0].nombre.split(" ")[0]} ${json[0].apellidos.split(" ")[0]}`;
        $cedulaMedico.innerText = `C.I: ${json[0].cedula}`;
        $nombresMedico.innerText = `${json[0].nombre}`;
        $apellidosMedico.innerText = `${json[0].apellidos}`;
        $tlfMedico.innerText = `${json[0].telefono}`;
        $direcMedico.innerText = `${json[0].direccion}`;
        $btnActualizar.setAttribute("onclick", `updateMedico(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteMedico(${id})`);

    } catch (error) {

        console.log(error);
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