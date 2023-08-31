import dinamicSelect2, { emptySelect2, select2OnClick, selectText } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import isBeforeToday from "../global/isBeforeToday.js";
import parseCitas from "./parseCitas.js";
import tipoAsegurado from "./tipoAsegurado.js";
import tipoTitular from "./tipoTitular.js";

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
        const seguroSelect = document.getElementById("s-seguro");
        const pacientesSelect = document.getElementById("s-paciente");


        emptySelect2({
            selectSelector: pacientesSelect,
            placeholder: "Seleccione un paciente",
            parentModal: "#modalReg",
            disable: false
        });

        // ** Para la función de dar click luego de 
        $("#s-paciente").on("select2:open", async function (e) {
            if (document.querySelector("#s-paciente").dataset.active == 0) {

                const obj = await getAll("pacientes/consulta");

                obj.forEach(el => {

                    if (el.tipo_paciente == 1) el.tipo_paciente = "Natural";
                    else if (el.tipo_paciente == 2) el.tipo_paciente = "Representante";
                    else if (el.tipo_paciente == 3) el.tipo_paciente = "Asegurado";
                    else if (el.tipo_paciente == 4) el.tipo_paciente = "Beneficiado";

                    if ($("#s-paciente").find(`option[value="${el.paciente_id}"]`).length) {
                        $("#s-paciente").val(el.paciente_id);
                    } else {
                        let newOption = new Option(selectText(["cedula", "nombre-apellidos", "tipo_paciente"], el), el.paciente_id, false, false);
                        $("#s-paciente").append(newOption);
                    }
                });

                $("#s-paciente").val(0).trigger('change.select2');
                $("#s-paciente").select2("close");
                document.querySelector("#s-paciente").dataset.active = 1;
            }

            $("#s-paciente").select2("open");
        })

        // console.log(parentModal);
        if ("#modalReg" !== null) {
            document.querySelector("#modalReg").addEventListener("hidden.bs.modal", e => {
                document.querySelector("#s-paciente").dataset.active = 0;
            })
        }

        $("#s-paciente").on("change", async function (e) {

            let paciente_id = this.value;
            const infoPaciente = await getById("pacientes", paciente_id);
            const inputRadioBeneficiado = document.getElementById("tipoPacienteBeneficiado");
            const inputTipoCita = document.getElementById("s-tipo_cita");
            const inputTipoCitaDefault = inputTipoCita.querySelector("option[value='default']");

            // ** Una vez se elija el paciente, permitir el cambio de tipo cita
            if (inputTipoCitaDefault !== null) {
                inputTipoCita.removeChild(inputTipoCitaDefault);
                inputTipoCita.disabled = false;
            }

            console.log(infoPaciente);

            // ** Si es representante o beneficiario
            if (infoPaciente.tipo_paciente == 2 || infoPaciente.tipo_paciente == 4) {
                document.querySelector(".input-radios-container").classList.remove("d-none");
                document.querySelector("label[for='input-radios-container'").classList.remove("d-none");
                document.getElementById("tipoPacienteBeneficiado").dataset.pacienteId = paciente_id;
                document.getElementById("tipoPacienteBeneficiado").dataset.tipoPaciente = infoPaciente.tipo_paciente;
                document.querySelector("label[for='seguro']").classList.add("d-none");
                inputTipoCita.querySelector("option[value='2']").disabled = true;
                inputTipoCita.querySelector("option[value='1']").selected = true;
                $('#s-seguro').next('.select2-container').fadeOut('slow');

                // ** Si esta selccionado como beneficiado
                if (inputRadioBeneficiado.checked) {
                    $('#s-titular').next('.select2-container').fadeIn('slow');
                    document.querySelector("label[for='titular_id'").classList.remove("d-none");
                    document.querySelector("#s-titular").dataset.active = 0;
                    tipoTitular(inputRadioBeneficiado);
                } else {
                    $('#s-titular').next('.select2-container').fadeOut('slow');
                }

                // ** Si es asegurado
            } else if (infoPaciente.tipo_paciente == 3) {
                // $('#s-seguro').next('.select2-container').fadeIn('slow');
                // document.querySelector("label[for='seguro']").classList.remove("d-none");
                document.querySelector("#s-seguro").dataset.active = 0;
                tipoAsegurado(infoPaciente.paciente_id);

                // ** En caso de la cita sea natural ocultar el select de seguros
                if (inputTipoCita.value == 1) {
                    document.querySelector("label[for='seguro']").classList.add("d-none");
                    $('#s-seguro').next('.select2-container').fadeOut('slow');
                }

                document.querySelector(".input-radios-container").classList.add("d-none");
                document.querySelector("label[for='input-radios-container").classList.add("d-none");
                document.querySelector("label[for='titular_id'").classList.add("d-none");
                $('#s-titular').next('.select2-container').fadeOut('slow');
                inputTipoCita.querySelector("option[value='2']").disabled = false;
            } else {
                document.querySelector(".input-radios-container").classList.add("d-none");
                document.querySelector("label[for='input-radios-container").classList.add("d-none");
                document.querySelector("label[for='titular_id'").classList.add("d-none");
                inputTipoCita.querySelector("option[value='2']").disabled = true;
                inputTipoCita.querySelector("option[value='1']").selected = true;
                document.querySelector("label[for='seguro']").classList.add("d-none");
                $('#s-seguro').next('.select2-container').fadeOut('slow');
                $('#s-titular').next('.select2-container').fadeOut('slow');
            }
        })


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

        // select2OnClick({
        //     selectSelector: "#s-seguro",
        //     selectValue: "seguro_id",
        //     selectNames: ["rif", "nombre"],
        //     module: "seguros/consulta",
        //     parentModal: "#modalReg",
        //     placeholder: "Seleccione un seguro"
        // });

        // $('#s-seguro').next('.select2-container').fadeOut('slow');
        // seguroSelect.disabled = true;
        especialidadSelect.disabled = true;

        $("#s-medico").on("change", async function (e) {

            $("#horarios-table").fadeOut("slow");

            let medico_id = this.value;
            const infoMedico = await getById("medicos", medico_id);
            const modalReg = document.querySelector("#modalReg .modal-body");
            const horariosTable = document.querySelector("#horarios-table tbody");

            $(especialidadSelect).empty().select2();

            console.log(infoMedico);

            dinamicSelect2({
                obj: infoMedico[0].especialidad ?? [],
                selectSelector: especialidadSelect,
                selectValue: "especialidad_id",
                selectNames: ["nombre_especialidad"],
                parentModal: "#modalReg",
                placeholder: "Seleccione una especialidad"
            });

            especialidadSelect.disabled = false;

            let listHorarios = "";
            infoMedico[0].horario.forEach(horario => {
                
                listHorarios += `
                    <tr>
                        <td>${horario.dias_semana}</td>
                        <td>${horario.hora_entrada}</td>
                        <td>${horario.hora_salida}</td>
                    </tr>
                `;
            })

            horariosTable.innerHTML = listHorarios;

            $("#horarios-table").fadeIn("slow");

            // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
            modalReg.scrollTo({
                top: modalReg.scrollHeight,
                bottom: 0,
                behavior: 'smooth'
            });
        })

        // dinamicSelect2({
        //     obj: [{ id: 1, text: "Normal" }, { id: 2, text: "Asegurada" }],
        //     selectNames: ["text"],
        //     selectValue: "id",
        //     selectSelector: "#s-tipo_cita",
        //     placeholder: "Seleccione el tipo de cita",
        //     parentModal: "#modalReg",
        //     staticSelect: true
        // });

        $("#s-tipo_cita").on("change", function (e) {

            let tipo_cita = this.value;

            if (tipo_cita == 1) {
                $('#s-seguro').next('.select2-container').fadeOut('slow');
                document.querySelector("label[for='seguro']").classList.add("d-none");
            } else {
                $('#s-seguro').next('.select2-container').fadeIn('slow');
                document.querySelector("label[for='seguro']").classList.remove("d-none");
                seguroSelect.disabled = false;
            }
        })



        const fecha = luxon.DateTime.fromISO(info.dateStr);
        const fechaActual = luxon.DateTime.now().toISODate();

        document.getElementById("fecha_cita").setAttribute("min", fechaActual);
        document.getElementById("fecha_cita").value = fecha.toISODate(); //`${info.dateStr}T${fecha_cita.hour.toString().padStart(2, '0')}:${fecha_cita.minute.toString().padStart(2, '0')}`;
        modalReg.show();
    },
    navLinks: true, // can click day/week names to navigate views
    selectable: false,
    selectMirror: false,
    eventClick: async function (arg) {

        const cita = await getById(module, arg.event._def.publicId);

        let estatusCita;

        switch (cita.estatus_cit) {
            case "1": estatusCita = "Asignada"; break;
            case "2": estatusCita = "Eliminada"; break;
            case "3": estatusCita = "Pendiente"; break;
            case "4": estatusCita = "Vista"; break;
            case "5": estatusCita = "Reasignada"; break;
        }

        if (cita.estatus_cit == 5) estatusCita = "Reasignada";


        document.getElementById("paciente").textContent = `${cita.nombre_paciente} ${cita.apellido_paciente}`;
        document.getElementById("cedula-titular").textContent = `C.I: ${cita.cedula_titular}`;
        document.getElementById("nombreMedico").textContent = `${cita.nombre_medico} ${cita.apellido_medico}`;
        document.getElementById("nombreEspecialidad").textContent = cita.nombre_especialidad;
        document.getElementById("tipoCita").textContent = (cita.tipo_cita == 1) ? "Normal" : "Asegurada";
        document.getElementById("estatusCita").textContent = estatusCita;
        (cita.estatus_cit == 1 || cita.estatus_cit == 3) ? document.getElementById("btn-reprogramar").setAttribute("onclick", `reprogramationCita(${cita.cita_id})`) : null;
        document.getElementById("fechaCita").value = cita.fecha_cita;
        document.getElementById("horaEntradaCita").value = cita.hora_entrada;
        document.getElementById("horaSalidaCita").value = cita.hora_salida;
        document.getElementById("fechaCita").value = cita.fecha_cita;
        document.getElementById("motivoCita").textContent = cita.motivo_cita;
        document.getElementById("claveCita").textContent = (cita.tipo_cita == 1) ? "No aplica" : cita.clave;
        document.getElementById("btn-actualizar").disabled = (cita.estatus_cit == 1) ? true : false;
        document.getElementById("btn-reprogramar").disabled = (cita.estatus_cit == 1 || cita.estatus_cit == 3) ? false : true;
        document.getElementById("export-cita").setAttribute("onclick", `openPopup('pdf/cita/${cita.cita_id}')`);
        (cita.estatus_cit == 1) ? null : document.getElementById("btn-actualizar").setAttribute("onclick", `updateCita(${cita.cita_id})`);
        document.getElementById("btn-actualizar").value = cita.cita_id;

        modalInfo.show();
    },
    editable: false,
    dayMaxEvents: true, // allow "more" link when too many events
});
calendar.render();

// ! Para actualizar
// let newOption = new Option("Hola", 1, true, true);
// $('#s-paciente').append(newOption).trigger('change');




