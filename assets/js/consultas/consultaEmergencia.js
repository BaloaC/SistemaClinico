import dinamicSelect2, { emptyAllSelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import pagoMedicosInput from "./pagoMedicosInput.js";

function turnInput(container, disabled) {
    const containerParent = document.querySelector(container);
    const elements = containerParent.querySelectorAll("input, select");
    elements.forEach((element) => {
        element.disabled = disabled;
    });
}


export default async function consultaEmergencia(inputRadio) {

    const pacienteSelect = document.getElementById("s-paciente");
    const pacienteBeneficiado = document.getElementById("cedula_beneficiado");
    const seguroSelect = document.getElementById("s-seguro-emergencia");
    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const citaSelect = document.getElementById("s-cita");
    const inputDateConsulta = document.querySelector("input[name='fecha_consulta']");
    const inputDateConsultaLabel = document.querySelector("label[for='fecha_consulta']");
    const inputDateConsultaHidden = document.getElementById("fecha_consulta_cita");

    const sinCitaSi = document.getElementById("consultaCitaSi");
    const sinCitaNo = document.getElementById("consultaCitaNo");

    // No es por emergencia
    if (inputRadio.value === "0") {

        const popover = bootstrap.Popover.getOrCreateInstance(document.getElementById('cedula_beneficiado'));
        if (popover._isEnabled) popover.hide();

        $(".sinCitaContainer").fadeIn("slow");
        $(".info-consulta-emergencia").fadeOut("slow");
        turnInput(".info-consulta-emergencia", true);
        $(".info-pago-medico").fadeOut("slow");
        turnInput(".info-pago-medico", true);
        $(".info-insumos-emergencia").fadeOut("slow");
        turnInput(".info-insumos-emergencia", true);
        turnInput(".inputPacienteBeneficiadoEmergencia", true);
        $("#addMedicoPago").fadeOut("slow");
        $("#addInsumo").fadeOut("slow");
        seguroSelect.disabled = true;
        sinCitaSi.value = 1;

        if (sinCitaNo.checked) {
            citaSelect.disabled = false
            $(".info-cita").fadeIn("slow");
            $(".info-paciente").fadeOut("slow");
            $(".info-medico").fadeOut("slow");
            pacienteSelect.disabled = true;
            medicoSelect.disabled = true;
            especialidadSelect.disabled = true;

            $(inputDateConsulta).fadeOut("slow");
            inputDateConsulta.disabled = true;
            $(inputDateConsultaLabel).fadeOut("slow");
            inputDateConsultaHidden.disabled = false;
        } else {
            $(".info-paciente").fadeIn("slow");
            $(".info-medico").fadeIn("slow");

            dinamicSelect2({
                // obj: pacientesList ?? [],
                selectSelector: "#s-paciente",
                selectValue: "paciente_id",
                selectNames: ["cedula", "nombre-apellidos"],
                parentModal: "#modalReg",
                placeholder: "Seleccione un paciente",
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

                                return tipo_paciente;
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

            pacienteSelect.disabled = false;
            medicoSelect.disabled = false;
            especialidadSelect.disabled = false;
            $(inputDateConsulta).fadeIn("slow");
            inputDateConsulta.disabled = false;
            $(inputDateConsultaLabel).fadeIn("slow");
            inputDateConsultaHidden.disabled = true;
        };



        $("#cedula_beneficiado-label").fadeOut("slow");
        $("#cedula_beneficiado").fadeOut("slow");
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        pacienteBeneficiado.disabled = true;

    } else { // Es por emergencia

        $(".sinCitaContainer").fadeOut("slow");
        $(".info-consulta-emergencia").fadeIn("slow");
        turnInput(".info-consulta-emergencia", false);
        turnInput(".info-pago-medico", false);
        turnInput(".info-insumos-emergencia", false);
        $(".info-cita").fadeOut("slow");
        $("#registrarPagoMedicoLabel").fadeIn("slow");
        $(".inputRadioPagoMedico").fadeIn("slow");
        $(".info-insumos-emergencia").fadeIn("slow");
        $("#addInsumo").fadeIn("slow");

        const pagoMedicosChecked = document.getElementById("RegistrarPagoMedicoSi");
        pagoMedicosChecked.checked ? pagoMedicosInput("1") : pagoMedicosInput("0");

        dinamicSelect2({
            // obj: pacientesList ?? [],
            selectSelector: "#s-paciente",
            selectValue: "paciente_id",
            selectNames: ["cedula", "nombre-apellidos"],
            parentModal: "#modalReg",
            placeholder: "Seleccione un paciente",
            ajax: true,
            ajaxUrl: "pacientes/consulta?tipo_paciente=3",
            queryPage: false,
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
                };
            }
        });

        emptyAllSelect2({
            selectSelector: "#cedula_beneficiado",
            placeholder: "Seleccione un paciente",
            parentModal: "#modalReg"
        })

        $("#s-paciente").on("change", async function (){ 

            let paciente_id = this.value;

            const pacientesBeneficiados = await getAll(`titularesBeneficiado/${paciente_id}`);

            if(pacientesBeneficiados?.length > 0){
                $(".inputPacienteBeneficiadoEmergencia").fadeIn("slow");
                $("#pacienteBeneficiadoEmergenciaLabel").fadeIn("slow");
                
            } else {
                
                $(".inputPacienteBeneficiadoEmergencia").fadeOut("slow");
                $("#pacienteBeneficiadoEmergenciaLabel").fadeOut("slow");
                const inputRadioPacienteBeneficiadoNo = document.getElementById("pacienteBeneficiadoEmergenciaNo");
                inputRadioPacienteBeneficiadoNo.checked = true;

                // Creamos un evento onchange para que no se muestre el select de los beneficiados
                const changeEvent = new Event("change");
                inputRadioPacienteBeneficiadoNo.dispatchEvent(changeEvent);
            }
            
            if(inputRadio.value === "1"){

                $("#cedula_beneficiado").empty().select2();

                dinamicSelect2({
                    // obj: pacientesList ?? [],
                    selectSelector: "#cedula_beneficiado",
                    selectValue: "paciente_id",
                    selectNames: ["cedula", "nombre-apellidos"],
                    parentModal: "#modalReg",
                    placeholder: "Seleccione un paciente",
                    ajax: true,
                    ajaxUrl: `titularesBeneficiado/${paciente_id}`,
                    queryPage: false,
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
        
                                data1.push({ id: cedula, text: `${cedula} - ${nombre} ${apellidos} - ${handleTipoPaciente(tipo_paciente)}` });
        
        
                            });
                        }
        
                        // Transforms the top-level key of the response object from 'data' to 'results'
                        return {
                            results: data1 ?? []
                        };
                    }
                });

            }
        });

        citaSelect.disabled = true;
        seguroSelect.disabled = true;
        sinCitaSi.value = 0;


        if (sinCitaNo.checked) {
            $(".info-paciente").fadeIn("slow");
            $(".info-medico").fadeIn("slow");
            pacienteSelect.disabled = false;
            medicoSelect.disabled = false;
            especialidadSelect.disabled = false;
        }

        if (pacienteSelect.value) seguroSelect.disabled = false;


        turnInput(".inputPacienteBeneficiadoEmergencia", false);
        $(".inputPacienteBeneficiadoEmergencia").fadeOut("slow");
        $("#pacienteBeneficiadoEmergenciaLabel").fadeOut("slow");
        $("#cedula_beneficiado-label").fadeIn("slow");
        $("#cedula_beneficiado").fadeIn("slow");
        $("#cedulaBeneficiadoSmall").fadeIn("slow");
        $(inputDateConsulta).fadeIn("slow");
        inputDateConsulta.disabled = false;
        $(inputDateConsultaLabel).fadeIn("slow");
        inputDateConsultaHidden.disabled = true;
    }

}

window.consultaEmergencia = consultaEmergencia;
