import concatItems from "../global/concatItems.js";
import dinamicSelect2, { emptySelect2 } from "../global/dinamicSelect2.js";
import formattedHour from "../global/formattedHour.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import isBeforeToday from "../global/isBeforeToday.js";
import sortScheduleByDay from "../global/sortScheduleByDay.js";
import to12HourFormat from "../global/to12HoursFormat.js";
import CitasManager from "./CitasManager.js";
import { cachedCitas } from "./cachedCitas.js";
import { citas } from "./parseCitas.js";
import parseCitas from "./parseCitas.js?v=1";
import tipoAsegurado from "./tipoAsegurado.js";
import tipoTitular from "./tipoTitular.js";


const module = "citas",
    modalReg = new bootstrap.Modal("#modalReg"),
    modalAlert = new bootstrap.Modal("#modalAlert"),
    modalInfo = new bootstrap.Modal("#modalInfo"),
    formReg = document.getElementById("info-cita");

const calendarEl = document.getElementById("calendar");
// const citas = async () => await parseCitas(await getAll(`${module}/consulta`));



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
    events: async function(fetchInfo, successCallback, failureCallback) {
        try {
            const eventos = await citas();
            successCallback(eventos);
        } catch (error) {
            failureCallback(error);
        }
    },
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
                    inputTipoCita.querySelector("option[value='2']").disable = false;
                    inputTipoCita.querySelector("option[value='2']").selected = true;
                    inputTipoCita.querySelector("option[value='1']").disabled = true;
                } else {
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
            if (infoPaciente.tipo_paciente == 4) {
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
                        inputTipoCita.querySelector("option[value='2']").disable = false;
                        inputTipoCita.querySelector("option[value='2']").selected = true;
                        inputTipoCita.querySelector("option[value='1']").disabled = true;
                    } else {
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
                placeholder: "Debe seleccionar una especialidad",
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
            $(".contact-medico").fadeOut("slow");

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
            // $(".contact-medico").fadeIn("slow");

            const infoMedico = await getById("medicos", this.value);
            const modalReg = document.querySelector("#modalReg .modal-body");
            const horariosTable = document.querySelector("#horarios-table tbody");
            const horariosOrdenados = sortScheduleByDay(infoMedico[0]?.horario);
            const forzarCitaSi = document.getElementById("forzar_cita_si");
            const forzarCitaNo = document.getElementById("forzar_cita_no");
            const numeroTelefonicoCita = document.getElementById("numeroTelefonicoMedico");
            const numeroTelefonicoCita1 = document.getElementById("numeroTelefonicoMedico1");

            numeroTelefonicoCita.innerText = infoMedico[0].telefono;
            numeroTelefonicoCita1.innerText = infoMedico[0].telefono;

            const citasManager = new CitasManager(horariosOrdenados, this.value);
            citasManager.obtenerCitas();

            // Para resetear los inputs y poder colocar hora fuera de los horarios en caso sea sí
            forzarCitaSi.onchange = () => citasManager.resetInputHoras();
            forzarCitaNo.onchange = () => citasManager.resetInputHoras();


            let listHorarios = "";
            horariosOrdenados?.forEach(horario => {
                listHorarios += `
                <tr>
                <td class="text-capitalize">${horario.dias_semana}</td>
                    <td>${to12HourFormat(horario.hora_entrada)}</td>
                    <td>${to12HourFormat(horario.hora_salida)}</td>
                    </tr>
              `;
            });

            horariosTable.innerHTML = listHorarios;

            if(listHorarios !== ""){
                $("#horarios-tableNotFound").fadeOut("slow");
                $(".medicoScheduleLabel").fadeIn("slow");
                $("#horarios-table").fadeIn("slow");
            }  else {
                $("#horarios-table").fadeOut("slow");
                $(".medicoScheduleLabel").fadeOut("slow");
                $("#horarios-tableNotFound").fadeIn("slow");
            }

            // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
            // modalReg.scrollTo({
            //     top: modalReg.scrollHeight,
            //     bottom: 0,
            //     behavior: 'smooth'
            // });
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

        // Ocultamos el popover si se selecciona desde el ver más
        $(".fc .fc-popover").fadeOut("slow");

        const cita = await getById(module, arg.event._def.publicId);
        let infoSeguro;
        const estatusCitaContainer = document.getElementById("estatusCita");

        if(cita.cita_seguro && cita.cita_seguro.length > 0){
            infoSeguro = await getById("seguros", cita?.cita_seguro[0]?.seguro_id);
        }

        let estatusCita;
        let claveCita = (cita.tipo_cita === 1) ? "No aplica" : ((cita.cita_seguro && cita.cita_seguro[0]) ? cita.cita_seguro[0].clave : "Por asignar");

        switch (cita.estatus_cit) {

            case "1": estatusCita = "Asignada"; 
                estatusCitaContainer.classList.remove("badge-warning");
                estatusCitaContainer.classList.remove("badge-success");
                estatusCitaContainer.classList.remove("badge-secondary");
                estatusCitaContainer.classList.remove("badge-danger");
                estatusCitaContainer.classList.add("badge-primary");
            break;
            case "2": estatusCita = "Eliminada"; 
                estatusCitaContainer.classList.remove("badge-warning");
                estatusCitaContainer.classList.remove("badge-success");
                estatusCitaContainer.classList.remove("badge-secondary");
                estatusCitaContainer.classList.remove("badge-primary");
                estatusCitaContainer.classList.add("badge-danger");
                break;
            case "3": estatusCita = "Pendiente"; 
                estatusCitaContainer.classList.remove("badge-primary");
                estatusCitaContainer.classList.remove("badge-danger");
                estatusCitaContainer.classList.remove("badge-warning");
                estatusCitaContainer.classList.remove("badge-success");
                estatusCitaContainer.classList.add("badge-secondary");
                break;
            case "4": estatusCita = "Vista"; 
                estatusCitaContainer.classList.remove("badge-secondary");
                estatusCitaContainer.classList.remove("badge-primary");
                estatusCitaContainer.classList.remove("badge-danger");
                estatusCitaContainer.classList.remove("badge-warning");
                estatusCitaContainer.classList.add("badge-success");
                break;
            case "5": estatusCita = "Reasignada";  
                estatusCitaContainer.classList.remove("badge-secondary");
                estatusCitaContainer.classList.remove("badge-primary");
                estatusCitaContainer.classList.remove("badge-success");
                estatusCitaContainer.classList.remove("badge-danger");
                estatusCitaContainer.classList.add("badge-warning");
            break;
        }

        if (cita.estatus_cit == 5){
            estatusCitaContainer.classList.remove("badge-secondary");
            estatusCitaContainer.classList.remove("badge-primary");
            estatusCitaContainer.classList.remove("badge-success");
            estatusCitaContainer.classList.remove("badge-danger");
            estatusCitaContainer.classList.add("badge-warning");
            estatusCita = "Reasignada";
        } 

        if (cita.cita_seguro && cita.cita_seguro[0]) {
            claveCita = cita.cita_seguro[0].clave;
        } else {
            claveCita = "Por asignar";
        }

        if (cita.tipo_cita == 1) {
            claveCita = "No aplica";
        }

        console.log(claveCita);
        
        if(claveCita === "No aplica" || claveCita === "Por asignar" || claveCita === null){

            document.querySelector(".claveCitaContainer").classList.add("d-none");
        } else {
            document.querySelector(".claveCitaContainer").classList.remove("d-none");
        }
        
        console.log(cita?.examenes?.length > 0);
        cita?.examenes?.length > 0 ? document.querySelector(".examenesDetalleCitaContainer").classList.remove("d-none") : document.querySelector(".examenesDetalleCitaContainer").classList.add("d-none");
            

        document.getElementById("paciente").textContent = `${cita.nombre_paciente} ${cita.apellido_paciente}`;
        document.getElementById("cedula-titular").textContent = `C.I: ${cita.cedula_titular}`;
        document.getElementById("nombreMedico").textContent = `${cita.nombre_medico} ${cita.apellido_medico}`;
        document.getElementById("nombreEspecialidad").textContent = cita.nombre_especialidad;
        document.getElementById("tipoCita").textContent = (cita.tipo_cita == 1) ? "Normal" : "Asegurada";
        document.getElementById("tipoServicio").textContent = (cita.tipo_servicio == 1) ? "Exámenes" : "Consulta";
        document.getElementById("estatusCita").textContent = estatusCita;
        (cita.estatus_cit == 1 || cita.estatus_cit == 3) ? document.getElementById("btn-reprogramar").setAttribute("onclick", `reprogramationCita(${cita.cita_id})`) : null;
        document.getElementById("fechaCita").value = cita.fecha_cita;
        document.getElementById("horaEntradaCita").value = cita.hora_entrada;
        document.getElementById("horaSalidaCita").value = cita.hora_salida;
        document.getElementById("fechaCita").value = cita.fecha_cita;
        document.getElementById("motivoCita").textContent = cita.motivo_cita;
        document.getElementById("claveCita").textContent = claveCita;
        document.getElementById("examenesCita").textContent = concatItems(cita.examenes, "nombre", "Sin exámenes", ",");
        document.getElementById("export-cita").setAttribute("onclick", cita.tipo_cita == 2 && cita.estatus_cit != 4 ? `openPopup('pdf/presupuestocita/${cita.cita_id}')` : `openPopup('pdf/cita/${cita.cita_id}')`);
        (cita.estatus_cit == 1) ? null : document.getElementById("btn-actualizar").setAttribute("onclick", `updateCita(${JSON.stringify(cita)})`);
        document.getElementById("btn-actualizar").value = JSON.stringify(cita);

        const diferenciaDeDias = (fechaActual, fechaAsignada) => {
            let unDia = 1000 * 60 * 60 * 24; // Milisegundos en un día
            let diferenciaEnMilisegundos =  fechaActual - fechaAsignada;
            let diferenciaEnDias = Math.round(diferenciaEnMilisegundos / unDia);
            return diferenciaEnDias;
        }

        const diferenciaDeDiasMaximo = diferenciaDeDias(new Date(), new Date(cita.fecha_cita));


        if(cita.estatus_cit == 1 || cita.estatus_cit == 4 || cita.estatus_cit == 5){

            document.getElementById("btn-actualizar").disabled = true;
            $("#btn-actualizar").fadeOut("slow");
        } else {


            if(diferenciaDeDiasMaximo <= infoSeguro?.maximo_dias){

                document.getElementById("btn-actualizar").disabled = false;
                $("#btn-actualizar").fadeIn("slow");
            } else {
                document.getElementById("btn-actualizar").disabled = true;
                $("#btn-actualizar").fadeOut("slow");
            }
            
        }
        
        if(cita.estatus_cit == 1 || cita.estatus_cit == 3) {

            document.getElementById("btn-reprogramar").disabled = false;
            $("#btn-reprogramar").fadeIn("slow");
        } else {
            
            document.getElementById("btn-reprogramar").disabled = true;
            $("#btn-reprogramar").fadeOut("slow");
        }

        modalInfo.show();
    },
    editable: false,
    dayMaxEvents: true, // allow "more" link when too many events
});


await calendar.render();

const horaEntradaInput = document.getElementById('hora_entrada');
const horaSalidaInput = document.getElementById('hora_salida');

horaEntradaInput.addEventListener("click", (event) => event.target.value === "" ? formattedHour(horaEntradaInput) : null);
horaSalidaInput.addEventListener("click", (event) => event.target.value === "" ? formattedHour(horaSalidaInput) : null);