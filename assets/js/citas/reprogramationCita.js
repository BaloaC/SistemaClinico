import getById from "../global/getById.js";
import sortScheduleByDay from "../global/sortScheduleByDay.js";
import to12HourFormat from "../global/to12HoursFormat.js";
import CitasManager from "./citasManager.js";

async function reprogramationCita(id) {
    const $form = document.getElementById("reprogramacion-cita");
    try {

        $("#horarios-table-reschedule").fadeOut("slow");
        $("#medicoRescheduleLabel").fadeOut("slow");

        const infoCita = await getById("citas", id);
        const infoMedico = await getById("medicos", infoCita.medico_id);
        const horariosOrdenados = sortScheduleByDay(infoMedico[0]?.horario);
        const horariosTable = document.getElementById("horarios-table-reschedule");
        const fechaCitaReprogramada = document.getElementById("fecha_cita_reprogramada");
        fechaCitaReprogramada.value = new Date().toISOString().split('T')[0];

        let listHorarios = "";
        horariosOrdenados.forEach(horario => {
            listHorarios += `
                <tr>
                <td class="text-capitalize">${horario.dias_semana}</td>
                    <td>${to12HourFormat(horario.hora_entrada)}</td>
                    <td>${to12HourFormat(horario.hora_salida)}</td>
                    </tr>
              `;
        });

        horariosTable.innerHTML = listHorarios;

        $("#horarios-table-reschedule").fadeIn("slow");
        $("#medicoRescheduleLabel").fadeIn("slow");

        const citasManager = new CitasManager(horariosOrdenados, infoMedico[0]?.medico_id);
        citasManager.obtenerCitas({ inputId: "fecha_cita_reprogramada" });
        citasManager.inputCitasHandler(false, true, true);
        citasManager.inputHoraEntraCita(null, "#hora_entrada2");
        citasManager.inputHoraSalidaCita(null, null, "#hora_salida2");

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "cita_id";
        $form.appendChild($inputId);

    } catch (error) {
        console.log(error);
    }
}

window.reprogramationCita = reprogramationCita;