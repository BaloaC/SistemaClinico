import getById from "../global/getById.js";
import { removeAddAnalist } from "../global/validateRol.js";
removeAddAnalist();
async function getExamen(id) {
    try {

        const nombreExamen = document.getElementById("nombreExamen");
        const especialidadExamen = document.getElementById("especialidadExamen");

        let especialidad = "";

        const json = await getById("examenes/", id);

        if (json.especialidades?.length >= 1) {

            json.especialidades.forEach(el => {
                especialidad += `
                <button class="btn btn-sm btn-empresa" id="btn-add" value="${el.examen_especialidad_id}" ${json.especialidades.length > 1
                        ? `onclick=(deleteEspecialidad(${el.examen_especialidad_id})) data-bs-toggle="modal" data-bs-target="#modalDeleteRelacion"`
                        : `data-bs-toggle="modal" data-bs-target="#modalAlert"`}>
                    ${el.nombre}
                    <i class="fa-sm fas fa-times"></i> 
                </button>
            `;
            });

            especialidadExamen.innerHTML = especialidad;

        } else {

            especialidadExamen.innerHTML = "Este exámen no posee ninguna especialidad";
        }

        nombreExamen.innerText = json.nombre;

    } catch (error) {

        console.log(error);
    }
}

window.getExamen = getExamen;