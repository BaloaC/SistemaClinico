import getById from "../global/getById.js";
import { removeAddAnalist } from "../global/validateRol.js";
import to12HourFormat from "../global/to12HoursFormat.js";
import sortScheduleByDay from "../global/sortScheduleByDay.js";
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


            const horariosOrdenados = sortScheduleByDay(json[0].horario);

            horariosOrdenados.forEach(el => {
                horario += `
                    <tr>
                        <td class="text-capitalize">${el.dias_semana}</td>
                        <td>${to12HourFormat(el.hora_entrada)}</td>
                        <td>${to12HourFormat(el.hora_salida)}</td>
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