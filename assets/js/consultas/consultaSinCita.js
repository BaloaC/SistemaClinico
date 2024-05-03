import dinamicSelect2, { emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";


export default async function consultaSinCita(inputRadio) {
    
    const pacienteSelect = document.getElementById("s-paciente");
    const medicoSelect = document.getElementById("s-medico");
    const especialidadSelect = document.getElementById("s-especialidad");
    const citaSelect = document.getElementById("s-cita");
    
    const consultaCita = document.querySelector(".input[name='consultaPorEmergencia']:checked");
    
    if(inputRadio.value === "0"){

        pacienteSelect.disabled = true;
        medicoSelect.disabled = true;
        especialidadSelect.disabled = true;
        citaSelect.disabled = false;
        $(".info-cita").fadeIn("slow");
        $(".info-paciente").fadeOut("slow");
        $(".info-medico").fadeOut("slow");
    } else{

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
                

                console.log(typeof data, data);

                if(typeof data === "object" && data?.data !== 0){
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

        pacienteSelect.disabled = false;
        medicoSelect.disabled = false;
        especialidadSelect.disabled = false;
        citaSelect.disabled = true;
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        $(".inputPacienteBeneficiadoEmergencia").fadeOut("slow");
        $("#pacienteBeneficiadoEmergenciaLabel").fadeOut("slow");
        $("#cedulaBeneficiadoSmall").fadeOut("slow");
        $(".info-cita").fadeOut("slow");
        $(".info-paciente").fadeIn("slow");
        $(".info-medico").fadeIn("slow");
    }

}

window.consultaSinCita = consultaSinCita;
