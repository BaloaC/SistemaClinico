import concatItems from "../global/concatItems.js";
import dinamicSelect2, { emptySelect2, select2OnClick, selectText } from "../global/dinamicSelect2.js";
import formattedHour from "../global/formattedHour.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import isBeforeToday from "../global/isBeforeToday.js";
import sortScheduleByDay from "../global/sortScheduleByDay.js";
import to12HourFormat from "../global/to12HoursFormat.js";
import CitasManager from "./citasManager.js";
import parseCitas from "./parseCitas.js";
import tipoAsegurado from "./tipoAsegurado.js";
import tipoTitular from "./tipoTitular.js";


const module = "citas",
    modalReg = new bootstrap.Modal("#modalReg"),
    modalAlert = new bootstrap.Modal("#modalAlert"),
    modalInfo = new bootstrap.Modal("#modalInfo"),
    formReg = document.getElementById("info-cita");

const calendarEl = document.getElementById("calendar");
const citas = async () => parseCitas(await getAll(`${module}/consulta`));

export const calendar = new FullCalendar.Calendar(calendarEl, {
    locale: "es",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
    },
    eventTimeFormat: {
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short',
        hour12: true
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
        const medicoSelect = document.getElementById("s-medico");
        const seguroSelect = document.getElementById("s-seguro");
        const pacientesSelect = document.getElementById("s-paciente");
        const examenSelect = document.getElementById("s-examen");


        emptySelect2({
            selectSelector: examenSelect,
            placeholder: "Cargando",
            parentModal: "#modalReg",
        });

        examenSelect.disabled = true;

        emptySelect2({
            selectSelector: pacientesSelect,
            placeholder: "Seleccione un paciente",
            parentModal: "#modalReg",
            disable: false
        });

        dinamicSelect2({
            selectSelector: pacientesSelect,
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos", "tipo_paciente"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un paciente",
            selectWidth: "100%",
            ajax: true,
            ajaxUrl: "pacientes/consulta",
            processResultsAjax: function (data, params) {

                const data1 = [];


                console.log(typeof data, data);

                if (typeof data === "object" && data?.data !== 0) {
                    data?.data.forEach(object => {
                        const { paciente_id: valorPropiedad1, cedula, nombre, apellidos, tipo_paciente } = object;

                        const handleTipoPaciente = (tipo_paciente) => {
                            if (tipo_paciente == 1) tipo_paciente = "Natural";
                            else if (tipo_paciente == 2) tipo_paciente = "Representante";
                            else if (tipo_paciente == 3) tipo_paciente = "Asegurado";
                            else if (tipo_paciente == 4) tipo_paciente = "Beneficiado";

                            return tipo_paciente
                        }

                        data1.push({ id: valorPropiedad1, text: `${cedula} - ${nombre} ${apellidos} - ${handleTipoPaciente(tipo_paciente)}` });
                    });
                }

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1 ?? [],
                    pagination: {
                        more: data1.length
                    }
                };
            }
        });

        const radioTipoPacienteHandler = (infoPaciente) => {
            const inputRadioBeneficiado = document.getElementById("tipoPacienteBeneficiado");
            const inputTipoCita = document.getElementById("s-tipo_cita");

            if (infoPaciente.edad >= 18 && infoPaciente.tipo_paciente == 4) {
                if (inputRadioBeneficiado.checked) {
                    alert("beneficiado");
                    inputTipoCita.querySelector("option[value='2']").disable = false;
                    inputTipoCita.querySelector("option[value='2']").selected = true;
                    inputTipoCita.querySelector("option[value='1']").disabled = true;
                } else {
                    alert("titular");
                    inputTipoCita.querySelector("option[value='1']").disable = false;
                    inputTipoCita.querySelector("option[value='1']").selected = true;
                    inputTipoCita.querySelector("option[value='2']").disabled = true;
                }
            }

        }


        $("#s-paciente").on("change", async function (e) {

            let paciente_id = this.value;
            const infoPaciente = await getById("pacientes", paciente_id);
            const inputRadioBeneficiado = document.getElementById("tipoPacienteBeneficiado");
            const inputRadioTitular = document.getElementById("tipoPacienteTitular");
            const inputTipoCita = document.getElementById("s-tipo_cita");
            const inputTipoCitaDefault = inputTipoCita.querySelector("option[value='default']");

            inputRadioBeneficiado.addEventListener("change", () => { radioTipoPacienteHandler(infoPaciente) });
            inputRadioTitular.addEventListener("change", () => { radioTipoPacienteHandler(infoPaciente) });

            // ** Una vez se elija el paciente, permitir el cambio de tipo cita
            if (inputTipoCitaDefault !== null) {
                inputTipoCita.removeChild(inputTipoCitaDefault);
                inputTipoCita.disabled = false;
            }

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

                // ** Si es beneficiado y menor de edad, siempre será benficiado por ende solo selccionamos directamente la opción en el input radio
                if (infoPaciente.edad < 18 && infoPaciente.tipo_paciente == 4) {
                    document.querySelector(".input-radios-container").classList.add("d-none");
                    document.querySelector("label[for='input-radios-container'").classList.add("d-none");

                    inputRadioBeneficiado.checked = true;

                    $('#s-titular').next('.select2-container').fadeIn('slow');
                    document.querySelector("label[for='titular_id'").classList.remove("d-none");
                    document.querySelector("#s-titular").dataset.active = 0;
                    tipoTitular(inputRadioBeneficiado);
                }

                if (infoPaciente.edad >= 18 && infoPaciente.tipo_paciente == 4) {
                    if (inputRadioBeneficiado.checked) {
                        alert("beneficiado1");
                        inputTipoCita.querySelector("option[value='2']").disable = false;
                        inputTipoCita.querySelector("option[value='2']").selected = true;
                        inputTipoCita.querySelector("option[value='1']").disabled = true;
                    } else {
                        alert("titular1");
                        inputTipoCita.querySelector("option[value='1']").disable = false;
                        inputTipoCita.querySelector("option[value='1']").selected = true;
                        inputTipoCita.querySelector("option[value='2']").disabled = true;
                    }
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

        // Validamos que ya se encuentre inicializado y con datos el select2
        if (!medicoSelect.value) {

            emptySelect2({
                selectSelector: medicoSelect,
                placeholder: "Debe seleccionar un médico",
                parentModal: "#modalReg"
            })

            medicoSelect.disabled = true;
        }

        // Validamos que ya se encuentre inicializado y con datos el select2
        if (!especialidadSelect.value) {

            dinamicSelect2({
                selectSelector: `#${especialidadSelect.id}`,
                selectValue: "especialidad_id",
                selectNames: ["nombre_especialidad"],
                parentModal: "#modalReg",
                placeholder: "Seleccione una especialidad",
                ajax: true,
                ajaxUrl: "especialidades/medicos",
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = data?.data.map(object => {
                        const { especialidad_id: valorPropiedad1, nombre: valorPropiedad2 } = object;
                        return { id: valorPropiedad1, text: valorPropiedad2 };
                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1,
                        pagination: {
                            more: data1.length
                        }
                    };
                }
            });
        }

        $(especialidadSelect).on("change", async function (e) {

            $("#horarios-table").fadeOut("slow");
            $("#citas-table").fadeOut("slow");
            $(".medicoScheduleLabel").fadeOut("slow");
            $(".citaScheduleLabel").fadeOut("slow");

            const citasManager = new CitasManager();
            citasManager.inputCitasHandler(true, true);

            let especialidad_id = this.value;
            $(medicoSelect).empty().select2();

            dinamicSelect2({
                selectSelector: "#s-medico",
                selectValue: "medico_id",
                selectNames: ["cedula", "nombre-apellidos"],
                ajax: true,
                ajaxUrl: `/medicos/especialidad/${especialidad_id}`,
                parentModal: "#modalReg",
                placeholder: "Seleccione un médico",
                queryPage: false,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = [];

                    data?.data.map(object => {
                        const { medico_id: valorPropiedad1, nombre: nombreMedico, cedula: cedulaMedico, apellidos: apellidoMedico, especialidad } = object;
                        data1.push({ id: valorPropiedad1, text: `${cedulaMedico} - ${nombreMedico} ${apellidoMedico}` });

                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1
                    };
                }
            });

            medicoSelect.disabled = false;

            $(examenSelect).empty().select2();

            dinamicSelect2({
                // obj: examenesList,
                selectSelector: examenSelect,
                selectValue: "examen_id",
                selectNames: ["nombre"],
                parentModal: "#modalReg",
                placeholder: "Seleccione los exámenes",
                multiple: true,
                ajax: true,
                ajaxUrl: `/examenes/especialidad/${especialidad_id}`,
                queryPage: false,
                processResultsAjax: function (data, params) {

                    params.page = params.page || 1;

                    const data1 = data?.data.map(object => {
                        const { examen_id: valorPropiedad1, nombre: nombreExamen } = object;
                        return { id: valorPropiedad1, text: nombreExamen };
                    });

                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1
                    };
                }
            });

            examenSelect.disabled = false;
        });

        $(medicoSelect).on("change", async function () {

            $("#horarios-table").fadeOut("slow");
            $("#citas-table").fadeOut("slow");
            $(".medicoScheduleLabel").fadeOut("slow");
            $(".citaScheduleLabel").fadeOut("slow");

            const infoMedico = await getById("medicos", this.value);
            const modalReg = document.querySelector("#modalReg .modal-body");
            const horariosTable = document.querySelector("#horarios-table tbody");
            const horariosOrdenados = sortScheduleByDay(infoMedico[0]?.horario);
            const forzarCitaSi = document.getElementById("forzar_cita_si");
            const forzarCitaNo = document.getElementById("forzar_cita_no");

            //         lunes: 1,
            //         martes: 2,
            //         miercoles: 3,
            //         jueves: 4,
            //         viernes: 5,
            //         sabado: 6,
            //         domingo: 0
            //     }

            //     const availableDays = [];

            //     schedule.map(scheduleOfTheDay => {
            //         availableDays.push(daysOfWeek[scheduleOfTheDay.dias_semana]);
            //     })

            //     const busyHours = [];

            //     flatpickr("#fecha_cita", {
            //         locale: "es",
            //         onDayCreate: async function (dObj, dStr, fp, dayElem) {

            //             let dateDayElem = dayElem.dateObj.toISOString().split('T')[0];
            //             const citasByDate = await getAll(`/citas/fecha?fecha=${dateDayElem}&medico=${idMedic}`);

            //             if (citasByDate.length > 0) {

            //                 const busyHour = [];
            //                 citasByDate.map(cita => {
            //                     busyHour.push({
            //                         hora_entrada: cita.hora_entrada,
            //                         hora_salida: cita.hora_salida
            //                     })
            //                 });

            //                 busyHours.push({ [dateDayElem]: busyHour })

            //                 console.log(busyHours);
            //             }
            //         },
            //         "disable": [
            //             function (date) {

            //                 // disable weekend days
            //                 // return true to disable
            //                 return (date.getDay() === 0 || date.getDay() === 6);

            //             }
            //         ],
            //     });

            //     console.log(busyHours);

            //     const limit = [
            //         ["13:00", "14:00"],
            //         ["16:00", "17:30"],
            //         ["18:00", "20:30"]
            //     ];

            //     // document.querySelector("hora_entrada").addEventListener("change", function () {
            //     //     // obtenemos el valor introducido por el usuario
            //     //     const user = this.value.split(":");

            //     //     // recorremos todas las fechas limite
            //     //     // Si devuelve true, esta entre algunas de las fechas
            //     //     const result = limit.some(el => {
            //     //         let start = el[0].split(":");
            //     //         let end = el[1].split(":");

            //     //         // comprobamos que este entre las fechas limite
            //     //         return (start[0] < user[0] || (start[0] == user[0] && start[1] <= user[1])) && (end[0] > user[0] || (end[0] == user[0] && end[1] >= user[1]))
            //     //     });

            //     //     document.getElementById("info").innerHTML = result ? "Correcto" : "Error";
            //     // });

            // }

            // inputDateHandler(horariosOrdenados, this.value);
            // 
            const citasManager = new CitasManager(horariosOrdenados, this.value);
            citasManager.obtenerCitas();

            // Para resetear los inputs y poder colocar hora fuera de los horarios en caso sea sí
            forzarCitaSi.onchange = () => citasManager.resetInputHoras();
            forzarCitaNo.onchange = () => citasManager.resetInputHoras();


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

            $("#horarios-table").fadeIn("slow");

            // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
            modalReg.scrollTo({
                top: modalReg.scrollHeight,
                bottom: 0,
                behavior: 'smooth'
            });
        });

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
        let claveCita = (cita.tipo_cita === 1) ? "No aplica" : ((cita.cita_seguro && cita.cita_seguro[0]) ? cita.cita_seguro[0].clave : "Por asignar");

        switch (cita.estatus_cit) {
            case "1": estatusCita = "Asignada"; break;
            case "2": estatusCita = "Eliminada"; break;
            case "3": estatusCita = "Pendiente"; break;
            case "4": estatusCita = "Vista"; break;
            case "5": estatusCita = "Reasignada"; break;
        }

        if (cita.estatus_cit == 5) estatusCita = "Reasignada";

        if (cita.cita_seguro && cita.cita_seguro[0]) {
            claveCita = cita.cita_seguro[0].clave;
        } else {
            claveCita = "Por asignar";
        }

        if (cita.tipo_cita == 1) {
            claveCita = "No aplica";
        }



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
        document.getElementById("claveCita").textContent = claveCita;
        document.getElementById("examenesCita").textContent = concatItems(cita.examenes, "nombre", "Sin exámenes", ",");
        document.getElementById("btn-actualizar").disabled = (cita.estatus_cit == 1 || cita.estatus_cit == 4) ? true : false;
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

const horaEntradaInput = document.getElementById('hora_entrada');
const horaSalidaInput = document.getElementById('hora_salida');

horaEntradaInput.addEventListener("click", (event) => event.target.value === "" ? formattedHour(horaEntradaInput) : null);
horaSalidaInput.addEventListener("click", (event) => event.target.value === "" ? formattedHour(horaSalidaInput) : null);