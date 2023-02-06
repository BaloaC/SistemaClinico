import getAll from "../global/getAll.js";

export async function mostrarExamenes() {

    try {

        const listadoExamenes = await getAll("examenes/consulta"),
            $cardTemplate = document.getElementById("card-template").content,
            $examenesContainer = document.getElementById("examenes-container"),
            $fragment = document.createDocumentFragment();

        listadoExamenes.forEach(el => {

            let $nombreExamen = $cardTemplate.querySelector("h3"),
                $tipo = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
                $btnActualizar = $cardTemplate.querySelector(".list-group li:nth-child(2) #btn-actualizar"),
                $btnEliminar = $cardTemplate.querySelector(".list-group li:nth-child(2) #btn-eliminar");
                
            $nombreExamen.textContent = el.nombre;
            $tipo.textContent = el.tipo;
            $btnActualizar.setAttribute("onclick", `updateExamen(${el.examen_id})`);
            $btnEliminar.setAttribute("onclick", `deleteExamen(${el.examen_id})`);

            let clone = document.importNode($cardTemplate, true);
            $fragment.appendChild(clone);
        })

        $examenesContainer.replaceChildren();
        $examenesContainer.appendChild($fragment);

    } catch (error) {
        console.log(error);
    }
}

addEventListener("DOMContentLoaded", mostrarExamenes);