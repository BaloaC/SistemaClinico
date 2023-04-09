import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import isBeforeToday from "../global/isBeforeToday.js";
import parseCitas from "./parseCitas.js";

const module = "citas",
    modalReg = new bootstrap.Modal("#modalReg"),
    modalAlert = new bootstrap.Modal("#modalAlert"),
    modalInfo = new bootstrap.Modal("#modalInfo"),
    formReg = document.getElementById("info-cita");

const calendarEl = document.getElementById("calendar"),
    citas = async () => parseCitas(await getAll(`${module}/consulta`));

export const calendar = new FullCalendar.Calendar(calendarEl, {
    locale: "es",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
    },
    events: citas,
    dateClick: async info => {

        if (isBeforeToday(info.date)) {

            const alertMessage = document.getElementById("alertMessage");

            alertMessage.textContent = "No es posible asignar una cita antes de la fecha actual";
            alertMessage.classList.remove("d-none");
            modalAlert.show();
            return;

        }

        const especialidadSelect = document.getElementById("s-especialidad");

        select2OnClick({
            selectSelector: "#s-paciente",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            module: "pacientes/consulta",
            parentModal: "#modalReg",
            placeholder: "Seleccione un paciente"
        });

        // TODO: Colocar en la vista los horarios disponible de este medico
        select2OnClick({
            selectSelector: "#s-medico",
            selectValue: "medico_id",
            selectNames: ["cedula", "nombre-apellidos"],
            module: "medicos/consulta",
            parentModal: "#modalReg",
            placeholder: "Seleccione un médico"
        });

        emptySelect2({
            selectSelector: especialidadSelect,
            placeholder: "Debe seleccionar un médico",
            parentModal: "#modalReg"
        })

        select2OnClick({
            selectSelector: "#s-seguro",
            selectValue: "seguro_id",
            selectNames: ["rif", "nombre"],
            module: "seguros/consulta",
            parentModal: "#modalReg",
            placeholder: "Seleccione un seguro"
        });

        especialidadSelect.disabled = true;
        // TODO: Al seleccionar/cambiar el valor del medico, cargar unicamente sus especialidades, crear el input vacio afuera
        $("#s-medico").on("change", async function (e) {

            const especialidades = await getAll("especialidades/consulta");
            $(especialidadSelect).empty().select2();

            dinamicSelect2({
                obj: especialidades,
                selectSelector: especialidadSelect,
                selectValue: "especialidad_id",
                selectNames: ["nombre"],
                parentModal: "#modalReg",
                placeholder: "Seleccione una especialidad"
            });

            especialidadSelect.disabled = false;
        })

        dinamicSelect2({
            obj: [{ id: 1, text: "Normal" }, { id: 2, text: "Asegurada" }],
            selectNames: ["text"],
            selectValue: "id",
            selectSelector: "#s-tipo_cita",
            placeholder: "Seleccione el tipo de cita",
            parentModal: "#modalReg",
            staticSelect: true
        });


        let date = new Date();
        var DateTime = luxon.DateTime;
        console.log(DateTime.fromISO(info.dateStr));
        document.getElementById("fecha_cita").value = DateTime.fromISO(info.dateStr);
        modalReg.show();
    },
    navLinks: true, // can click day/week names to navigate views
    selectable: false,
    selectMirror: false,
    eventClick: async function (arg) {

        const cita = await getById(module, arg.event._def.publicId);

        document.getElementById("paciente").textContent = cita[0].nombre_paciente;
        document.getElementById("cedula-titular").textContent = `C.I: ${cita[0].cedula_titular}`;
        document.getElementById("nombreMedico").textContent = cita[0].nombre_medico;
        document.getElementById("nombreEspecialidad").textContent = cita[0].nombre_especialidad;
        document.getElementById("tipoCita").textContent = (cita[0].tipo_cita == 1) ? "Normal" : "Asegurada";
        document.getElementById("estatusCita").textContent = (cita[0].estatus_cit == 1) ? "Asignada" : "Pendiente";
        document.getElementById("fechaCita").value = cita[0].fecha_cita;
        document.getElementById("motivoCita").textContent = cita[0].motivo_cita;
        document.getElementById("claveCita").textContent = (cita[0].tipo_cita == 1) ? "No aplica" : cita[0].clave;
        document.getElementById("btn-actualizar").disabled = (cita[0].estatus_cit == 1) ? true : false;
        (cita[0].estatus_cit == 1) ? null : document.getElementById("btn-actualizar").setAttribute("onclick", `updateCita(${cita[0].cita_id})`);
        document.getElementById("btn-actualizar").value = cita[0].cita_id;

        modalInfo.show();
    },
    editable: false,
    dayMaxEvents: true, // allow "more" link when too many events
});
calendar.render();

// ! Para actualizar
// let newOption = new Option("Hola", 1, true, true);
// $('#s-paciente').append(newOption).trigger('change');




