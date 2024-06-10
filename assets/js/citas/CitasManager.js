import getAll from "../global/getAll.js";
import to12HourFormat from "../global/to12HoursFormat.js";


export default class CitasManager {
    constructor(schedule = null, idMedic = null) {
        this.idMedic = idMedic;
        this.schedule = schedule;
    }

    async obtenerCitasPorFecha(dateDayElem) {
        const citasByDate = await getAll(`/citas/fecha?fecha=${dateDayElem}&medico=${this.idMedic}`);
        return citasByDate;
    }

    inputCitasHandler(disabled, inicializated, reschedule = false) {

        const fechaCita = document.getElementById("fecha_cita");
        const horaEntradaInput = document.getElementById("hora_entrada");
        const horaSalidaInput = document.getElementById("hora_salida");

        // Si no están inicializados se puede acceder mendiante el html normal, sino debe ser por el input que se crea 
        if (!inicializated) {

            fechaCita.disabled = disabled;
            horaEntradaInput.disabled = disabled;
            horaSalidaInput.disabled = disabled;
        } else {

            document.querySelectorAll(reschedule === false ? ".fecha_cita" : ".fecha_cita_reprogramada").forEach(element => element.disabled = disabled)
            document.querySelectorAll(reschedule === false ? ".hora_entrada" : ".hora_entrada2").forEach(element => element.disabled = disabled)
            document.querySelectorAll(reschedule === false ? ".hora_salida" : ".hora_salida2").forEach(element => element.disabled = disabled)
        }
    }

    async obtenerCitas({ inputId = "fecha_cita" } = {}) {

        const daysOfWeek = { lunes: 1, martes: 2, miercoles: 3, jueves: 4, viernes: 5, sabado: 6, domingo: 0 }
        const availableDays = [];

        this.schedule?.map(scheduleOfTheDay => {
            availableDays.push(daysOfWeek[scheduleOfTheDay.dias_semana]);
        })

        this.inputCitasHandler(false, false);
        $(".medicoScheduleLabel").fadeIn("slow");
        $(".citaScheduleLabel").fadeIn("slow");

        const flatpickrPromise = new Promise((resolve, reject) => {

            flatpickr(`#${inputId}`, {
                locale: "es",
                minDate: "today",
                dateFormat: "Y-m-d",
                altFormat: "d-m-Y",
                altInput: true,
                onChange: async (selectedDates, dateStr, instance) => {

                    const listCitasByDate = await this.obtenerCitasPorFecha(dateStr);
                    const horarioDelDia = this.obtenerHorarioDelDiaPorMedico(dateStr);


                    if (inputId === "fecha_cita") {
                        this.mostrarCitasDelDia(listCitasByDate);

                        if (horarioDelDia && horarioDelDia.length > 0) {

                            this.inputHoraEntraCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) });
                            this.inputHoraSalidaCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) });
                        } else {
                            this.inputHoraEntraCita(null)
                            this.inputHoraSalidaCita(null);
                        }

                    } else { //Si no es en el registro de citas (reprogramar citas), no limitar las horas
                        this.mostrarCitasDelDia(listCitasByDate, { citasTableClass: "#citas-table-reschedule", citasTableBodyClass: "#citas-table-reschedule tbody", withoutCitasClass: ".withoutCitasReschedule", modalRegClass: "#modalReprogramar .modal-body" });
                        this.inputHoraEntraCita(null, "#hora_entrada2");
                        this.inputHoraSalidaCita(null, null, "#hora_salida2");
                    }

                    // Validamos que el mensaje de contacto con el médico aparezca si se hace click en un día fuera de su horario
                    if (instance.selectedDateElem.children[0].classList.contains("noWorking")) {
                        $(".contact-medico").fadeIn("slow");
                        $(".contact-medico1").fadeIn("slow");
                    } else {
                        $(".contact-medico").fadeOut("slow");
                        $(".contact-medico1").fadeOut("slow");
                    };

                    if(inputId === "fecha_cita_reprogramada"){

                        
                        let self = this;
                        
                        document.getElementById("hora_salida2").addEventListener("change", function(element) {

                            if((self.convertirAHoras(horarioDelDia[0].hora_salida) < self.convertirAHoras(element.target.value)) || (self.convertirAHoras(horarioDelDia[0].hora_entrada) > self.convertirAHoras(element.target.value))){
                                $(".outOfSchedule").fadeIn("slow");
                            } else {
                                $(".outOfSchedule").fadeOut("slow");
                            }
                        })
                        
                        document.getElementById("hora_entrada2").addEventListener("change", function(element) {

                            if((self.convertirAHoras(horarioDelDia[0].hora_salida) < self.convertirAHoras(element.target.value)) || (self.convertirAHoras(horarioDelDia[0].hora_entrada) > self.convertirAHoras(element.target.value))){
                                $(".outOfSchedule").fadeIn("slow");
                            } else {
                                $(".outOfSchedule").fadeOut("slow");
                            }
                        })

                        if(horarioDelDia && horarioDelDia.length === 0){
                            $(".outOfSchedule").fadeIn("slow");
                        }
                    }
                },
                onDayCreate: async (dObj, dStr, fp, dayElem) => {

                    const dateDayElem = dayElem.dateObj.toISOString().split('T')[0];
                    const listCitasByDate = await this.obtenerCitasPorFecha(dateDayElem);
                    const horarioDelDia = this.obtenerHorarioDelDiaPorMedico(dateDayElem);
                    const dateTime = new Date();
                    if (dateTime.getTime() <= dayElem.dateObj.getTime()) {

                        if (availableDays.includes(dayElem.dateObj.getDay())) {

                            let horasDisponibles = this.calcularHorasDisponiblesDelDia(horarioDelDia[0]?.hora_entrada.substring(0, 5), horarioDelDia[0]?.hora_salida.substring(0, 5), listCitasByDate)
                            dayElem.innerHTML += `<span class='event ${listCitasByDate.length > 0 && horasDisponibles <= 30 ? "busy" : ""}'></span>`;

                        } else {
                            dayElem.innerHTML += `<span class='event ${(dayElem.dateObj.getDay() === 0 || dayElem.dateObj.getDay() === 6) ? "disabled" : "noWorking"}'></span>`;
                        }
                    }

                    if (document.getElementById(inputId).value === dateDayElem) {

                        // Si la fecha seleccionada no está disponible en el horario del médico mostrar la información de contacto
                        // if (instance.selectedDateElem.children[0].classList.contains("noWorking")) {
                        //     $(".contact-medico").fadeIn("slow");
                        //     $(".contact-medico1").fadeIn("slow");
                        // } else {
                        //     $(".contact-medico").fadeOut("slow");
                        //     $(".contact-medico1").fadeOut("slow");
                        // };

                        inputId === "fecha_cita" ? this.mostrarCitasDelDia(listCitasByDate) : this.mostrarCitasDelDia(listCitasByDate, { citasTableClass: "#citas-table-reschedule tbody", withoutCitasClass: ".withoutCitasReschedule", modalRegClass: "#modalReprogramar .modal-body" });

                        if (horarioDelDia && horarioDelDia.length > 0) {
                            this.inputHoraEntraCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) })
                            this.inputHoraSalidaCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) })
                        } else {
                            this.inputHoraEntraCita(null)
                            this.inputHoraSalidaCita(null);
                        }


                        if(inputId === "fecha_cita_reprogramada"){

                        
                            let self = this;
                            
                            document.getElementById("hora_salida2").addEventListener("change", function(element) {
    
                                if((self.convertirAHoras(horarioDelDia[0].hora_salida) < self.convertirAHoras(element.target.value)) || (self.convertirAHoras(horarioDelDia[0].hora_entrada) > self.convertirAHoras(element.target.value))){
                                    $(".outOfSchedule").fadeIn("slow");
                                } else {
                                    $(".outOfSchedule").fadeOut("slow");
                                }
                            })
                            
                            document.getElementById("hora_entrada2").addEventListener("change", function(element) {
    
                                if((self.convertirAHoras(horarioDelDia[0].hora_salida) < self.convertirAHoras(element.target.value)) || (self.convertirAHoras(horarioDelDia[0].hora_entrada) > self.convertirAHoras(element.target.value))){
                                    $(".outOfSchedule").fadeIn("slow");
                                } else {
                                    $(".outOfSchedule").fadeOut("slow");
                                }
                            })
    
                            if(horarioDelDia && horarioDelDia.length === 0){
                                $(".outOfSchedule").fadeIn("slow");
                            }
                        }
                    };

                    
                },
                "disable": [
                    function (date) { return (date.getDay() === 0 || date.getDay() === 6); }
                ],
                onReady: resolve
            });
        });

        await flatpickrPromise;
    }

    // Método para convertir hora a minutos
    convertirAHoras(hora) {
        const partes = hora.split(":");
        const horas = partes[0];
        const minutos = partes[1];

        return parseInt(horas) * 60 + parseInt(minutos);
    }

    calcularHorasDisponiblesDelDia(minLimit, maxLimit, horariosOcupados) {

        // Rango total
        const rangoInicio = minLimit;
        const rangoFin = maxLimit;

        const inicioRangoMin = this.convertirAHoras(rangoInicio);
        const finRangoMin = this.convertirAHoras(rangoFin);
        const rangosOcupados = horariosOcupados.map(horario => { return { inicio: this.convertirAHoras(horario.hora_entrada), fin: this.convertirAHoras(horario.hora_salida) }; });

        // Calculo disponibilidad
        let disponible = finRangoMin - inicioRangoMin;
        rangosOcupados.forEach(rango => { disponible -= rango.fin - rango.inicio; });

        return disponible;
    }

    mostrarCitasDelDia(listCitasByDate, { citasTableBodyClass = "#citas-table tbody", citasTableClass = "#citas-table", withoutCitasClass = ".withoutCitas", modalRegClass = "#modalReg .modal-body" } = {}) {

        let listCitas = "";
        const citasTable = document.querySelector(citasTableBodyClass);
        const withoutCitas = document.querySelector(withoutCitasClass);
        const modalReg = document.querySelector(modalRegClass);

        if (listCitasByDate.length > 0) {

            $(withoutCitas).fadeOut("slow");

            listCitasByDate.forEach(horario => {
                listCitas += `
                    <tr>
                        <td>${to12HourFormat(horario.hora_entrada)}</td>
                        <td>${to12HourFormat(horario.hora_salida)}</td>
                    </tr>
                `;
            });

            citasTable.innerHTML = listCitas;
            $(citasTableClass).fadeIn("slow");
        } else {
            $(citasTableClass).fadeOut("slow");
            $(withoutCitas).fadeIn("slow");
        }

        // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
        // modalReg.scrollTo({
        //     top: modalReg.scrollHeight,
        //     bottom: 0,
        //     behavior: 'smooth'
        // });
    }

    inputHoraEntraCita(horario, inputId = "#hora_entrada") {

        const config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
            minuteIncrement: 5,
            altFormat: "h:i K",
            altInput: true,
            onChange: async (selectedDates, dateStr, instance) => { this.inputHoraSalidaCita(horario, dateStr, inputId !== "#hora_entrada" ? "#hora_salida2" : "#hora_salida"); }
        }

        if (typeof horario === "object" && horario?.hora_entrada && horario?.hora_salida) {

            config.maxTime = this.aumentarDecrementar30Minutos(horario?.hora_salida, false);
            config.minTime = horario.hora_entrada;
            config.defaultDate = horario.hora_entrada;
        } else {

            config.defaultDate = "08:00";
            config.minTime = "08:00";
            config.maxTime = "16:30";
            // delete config.minTime;
            // delete config.maxTime;
        }

        flatpickr(inputId, config);
    }

    inputHoraSalidaCita(horario, dateStr = null, inputId = "#hora_salida") {

        const config = { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: false, minuteIncrement: 5, altFormat: "h:i K", altInput: true }

        if (typeof horario === "object" && horario?.hora_entrada && horario?.hora_salida) {

            config.minTime = this.aumentarDecrementar30Minutos(dateStr ?? horario?.hora_entrada, true);
            config.maxTime = horario?.hora_salida;
            config.defaultDate = this.aumentarDecrementar30Minutos(dateStr ?? horario?.hora_entrada, true);
        } else {

            config.defaultDate = "08:00";
            config.minTime = this.aumentarDecrementar30Minutos(dateStr ?? horario?.hora_entrada, true);
            config.maxTime = "17:00";
            // delete config.maxTime;
        }

        flatpickr(inputId, config);
    }

    obtenerHorarioDelDiaPorMedico(dateStr) {

        const dias = ["domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];

        const horarioDelDia = this.schedule?.filter(scheduleOfTheDay => {
            return scheduleOfTheDay.dias_semana == dias[new Date(dateStr).getDay() + 1];
        })

        return horarioDelDia
    }

    aumentarDecrementar30Minutos(hora, aumento) {

        if (hora === undefined) return "08:00";

        // Separar las horas y los minutos
        const [horas, minutos] = hora.split(":").map(Number);

        // Crear un nuevo objeto Date con la fecha dada
        const nuevaFecha = new Date();
        nuevaFecha.setHours(horas); // Establecer las horas
        nuevaFecha.setMinutes(minutos); // Establecer los minutos

        if (aumento) {
            // Sumar 30 minutos
            nuevaFecha.setMinutes(nuevaFecha.getMinutes() + 30);
        } else {
            // Restar 30 minutos
            nuevaFecha.setMinutes(nuevaFecha.getMinutes() - 30);
        }

        // Obtener las nuevas horas y minutos
        const nuevasHoras = nuevaFecha.getHours();
        const nuevosMinutos = nuevaFecha.getMinutes();

        // Formatear la nueva fecha
        const nuevaFechaFormateada = `${nuevasHoras.toString().padStart(2, "0")}:${nuevosMinutos.toString().padStart(2, "0")}`;

        return nuevaFechaFormateada;
    }

    resetInputHoras() {
        const forzarCitaSi = document.getElementById("forzar_cita_si");

        if (forzarCitaSi.checked) {

            this.inputHoraEntraCita(null);
            this.inputHoraSalidaCita(null);
        } else {

            const horarioDelDia = this.obtenerHorarioDelDiaPorMedico(document.getElementById("fecha_cita").value);
            this.inputHoraEntraCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) })
            this.inputHoraSalidaCita({ hora_entrada: horarioDelDia[0]?.hora_entrada.substring(0, 5), hora_salida: horarioDelDia[0]?.hora_salida.substring(0, 5) })
        }

    }
}