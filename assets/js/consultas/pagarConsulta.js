import { createOptionOrSelectInstead } from "../global/dinamicSelect2.js";

function pagarConsulta({ citaType, consulta_id, paciente_id }) {

    if (citaType === "Normal") {

        let intervalId = null;
        let intervalIdConsulta = null;

        // Ejecutamos un intervalo hasta que sea seleccionado el paciente y se pueda obtener las consultas
        intervalId = setInterval(() => {

            let existingValue = $("#s-paciente-consulta").val(paciente_id);
            if (existingValue[0]?.value == paciente_id) {
                $("#s-paciente-consulta").val(paciente_id).trigger('change');
                clearInterval(intervalId);
            }
        }, 500);

        // Esperamos hasta tener las consultas listas y seleccionarla
        intervalIdConsulta = setInterval(() => {

            let existingValueConsulta = $("#s-consulta-normal").val(consulta_id);
            if (existingValueConsulta[0]?.value == consulta_id) {
                $("#s-consulta-normal").val(consulta_id).trigger('change');
                clearInterval(intervalIdConsulta);
            }
        }, 500);

    } else {

        let intervalId = null;

        // Ejecutamos un intervalo hasta que sea seleccionado la consulta
        intervalId = setInterval(() => {

            let existingValue = $("#s-consulta-seguro").val(consulta_id);
            if (existingValue[0]?.value == consulta_id) {
                $("#s-consulta-seguro").val(consulta_id).trigger('change');
                clearInterval(intervalId);
            }
        }, 500);    
    }
}

window.pagarConsulta = pagarConsulta;