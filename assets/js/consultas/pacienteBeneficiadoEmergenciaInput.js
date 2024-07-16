import dinamicSelect2 from "../global/dinamicSelect2.js";

export default async function pacienteBeneficiadoEmergenciaInput(inputRadio) {

    const beneficiadoSelect = document.getElementById("cedula_beneficiado");
    const beneficiadoSelectLabel = document.getElementById("cedula_beneficiado-label");

    if (inputRadio == "0") {


        $(".inputCedulaBeneficiado").fadeOut("slow")
        $(beneficiadoSelectLabel).fadeOut("slow");
        beneficiadoSelect.disabled = true;

    } else {

        $("#cedula_beneficiado").empty().select2();
        const paciente_id = document.getElementById("s-paciente").value;

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


        $(".inputCedulaBeneficiado").fadeIn("slow")
        $(beneficiadoSelectLabel).fadeIn("slow");
        beneficiadoSelect.disabled = false;
    }

}

window.pacienteBeneficiadoEmergenciaInput = pacienteBeneficiadoEmergenciaInput;
