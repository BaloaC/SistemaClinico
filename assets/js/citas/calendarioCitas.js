import dinamicSelect2, { emptySelect2, select2OnClick, selectText } from "../global/dinamicSelect2.js";
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

            console.log(infoPaciente);

            if (infoPaciente.tipo_paciente == 2 || infoPaciente.tipo_paciente == 4) {
                document.querySelector(".input-radios-container").classList.remove("d-none");
                document.querySelector("label[for='input-radios-container'").classList.remove("d-none");
                document.getElementById("tipoPacienteBeneficiado").dataset.pacienteId = paciente_id;
                document.getElementById("tipoPacienteBeneficiado").dataset.tipoPaciente = infoPaciente.tipo_paciente;

                if (inputRadioBeneficiado.checked) {
                    $('#s-titular').next('.select2-container').fadeIn('slow');
                    document.querySelector("label[for='titular_id'").classList.remove("d-none");
                    document.querySelector("#s-titular").dataset.active = 0;
                    tipoPaciente(inputRadioBeneficiado);
                } else {
                    $('#s-titular').next('.select2-container').fadeOut('slow');
                }
            } else {
                document.querySelector(".input-radios-container").classList.add("d-none");
                document.querySelector("label[for='input-radios-container").classList.add("d-none");
                document.querySelector("label[for='titular_id'").classList.add("d-none");
                $('#s-titular').next('.select2-container').fadeOut('slow');
            }
        })

        async function tipoPaciente(inputRadio) {
            if (inputRadio.value === "beneficiado") {
                const titularSelect = document.getElementById("s-titular");
                document.querySelector("label[for='titular_id'").classList.remove("d-none");

                if (titularSelect.dataset.create == 0) {
                    emptySelect2({
                        selectSelector: titularSelect,
                        placeholder: "Seleccione un paciente",
                        parentModal: "#modalReg",
                        disable: false,
                    });
                }

                $("#s-titular").on("select2:open", async function (e) {
                    if (document.querySelector("#s-titular").dataset.active == 0) {

                        // Vaciar opciones del elemento select
                        $("#s-titular").empty();

                        let paciente_id = inputRadio.dataset.pacienteId;
                        let tipo_paciente = inputRadio.dataset.tipoPaciente;
                        console.log(tipo_paciente);
                        let infoPaciente;

                        if (tipo_paciente == 2) {
                            infoPaciente = await getById("titularesBeneficiado", paciente_id);
                        } else {
                            infoPaciente = await getById("titulares", paciente_id);
                        }

                        if ('result' in infoPaciente && infoPaciente.result.code === false) return;

                        console.log(infoPaciente);

                        infoPaciente.forEach((el) => {


                            if (el.tipo_paciente == 1) el.tipo_paciente = "Natural";
                            else if (el.tipo_paciente == 2) el.tipo_paciente = "Representante";
                            else if (el.tipo_paciente == 3) el.tipo_paciente = "Asegurado";
                            else if (el.tipo_paciente == 4) el.tipo_paciente = "Beneficiado";

                            if ($("#s-titular").find(`option[value="${el.paciente_id}"]`).length) {
                                $("#s-titular").val(el.paciente_id);
                            } else {
                                let newOption = new Option(selectText(["cedula", "nombre-apellidos", "tipo_paciente"], el), el.paciente_id, false, false);
                                $("#s-titular").append(newOption);
                            }
                        });

                        // Construir uno nuevo con la información que necesitas
                        emptySelect2({
                            selectSelector: titularSelect,
                            placeholder: "Seleccione un paciente",
                            parentModal: "#modalReg",
                            disable: false,
                        });

                        $("#s-titular").val(0).trigger("change.select2");
                        $("#s-titular").select2("close");
                        document.querySelector("#s-titular").dataset.active = 1;
                    }

                    $("#s-titular").select2("open");
                });

                if ("#modalReg" !== null) {
                    document.querySelector("#modalReg").addEventListener("hidden.bs.modal", (e) => {
                        document.querySelector("#s-titular").dataset.active = 0;
                    });
                }
                // $('#s-titular').next('.select2-container').fadeOut('slow');
                // $('#s-titular').next('.select2-container').fadeIn('slow');
            } else {
                $('#s-titular').next('.select2-container').fadeOut('slow');
                document.querySelector("label[for='titular_id'").classList.add("d-none");
            }
        }

        window.tipoPaciente = tipoPaciente;


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

        $('#s-seguro').next('.select2-container').fadeOut('slow');
        seguroSelect.disabled = true;
        especialidadSelect.disabled = true;

        $("#s-medico").on("change", async function (e) {


            let medico_id = this.value;
            const infoMedico = await getById("medicos", medico_id);

            $(especialidadSelect).empty().select2();

            dinamicSelect2({
                obj: infoMedico[0].especialidad ?? [],
                selectSelector: especialidadSelect,
                selectValue: "especialidad_id",
                selectNames: ["nombre_especialidad"],
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

        $("#s-tipo_cita").on("change", function (e) {

            let tipo_cita = this.value;

            if (tipo_cita == 1) {
                $('#s-seguro').next('.select2-container').fadeOut('slow');
                document.querySelector("label[for='seguro'").classList.add("d-none");
            } else {
                $('#s-seguro').next('.select2-container').fadeIn('slow');
                document.querySelector("label[for='seguro'").classList.remove("d-none");
                seguroSelect.disabled = false;
            }
        })


        const DateTime = luxon.DateTime;
        const fecha_cita = DateTime.now(info.dateStr, { zone: 'utc' });

        document.getElementById("fecha_cita").value = `${fecha_cita.toISODate()}T${fecha_cita.hour}:${fecha_cita.minute.toString().padStart(2, '0')}`;
        modalReg.show();
    },
    navLinks: true, // can click day/week names to navigate views
    selectable: false,
    selectMirror: false,
    eventClick: async function (arg) {

        const cita = await getById(module, arg.event._def.publicId);

        document.getElementById("paciente").textContent = `${cita[0].nombre_paciente} ${cita[0].apellido_paciente}`;
        document.getElementById("cedula-titular").textContent = `C.I: ${cita[0].cedula_titular}`;
        document.getElementById("nombreMedico").textContent = `${cita[0].nombre_medico} ${cita[0].apellido_medico}`;
        document.getElementById("nombreEspecialidad").textContent = cita[0].nombre_especialidad;
        document.getElementById("tipoCita").textContent = (cita[0].tipo_cita == 1) ? "Normal" : "Asegurada";
        document.getElementById("estatusCita").textContent = (cita[0].estatus_cit == 1) ? "Asignada" : "Pendiente";
        document.getElementById("fechaCita").value = cita[0].fecha_cita;
        document.getElementById("motivoCita").textContent = cita[0].motivo_cita;
        document.getElementById("claveCita").textContent = (cita[0].tipo_cita == 1) ? "No aplica" : cita[0].clave;
        document.getElementById("btn-actualizar").disabled = (cita[0].estatus_cit == 1) ? true : false;
        document.getElementById("export-cita").setAttribute("onclick", `openPopup('pdf/cita/${cita[0].cita_id}')`);
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




