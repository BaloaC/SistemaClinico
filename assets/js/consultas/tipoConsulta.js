import consultaEmergencia from "./consultaEmergencia.js";

function turnInput(container, disabled) {
    const containerParent = document.querySelector(container);
    const elements = containerParent.querySelectorAll("input, select");
    elements.forEach((element) => {
        element.disabled = disabled;
    });
}

async function tipoConsultaSelect(input) {
    if (input.value === "examen") {
        turnInput(".info-consultaSinExamenes", true);
        $(".info-consultaSinExamenes").fadeOut("slow");
        turnInput(".info-examenes", false);
        $(".info-examenes").fadeIn("slow");
        turnInput(".examenSelect", true);
        $(".examenSelect").fadeOut("slow");
    } else {

        turnInput(".info-examenes", true);
        $(".info-examenes").fadeOut("slow");
        turnInput(".info-consultaSinExamenes", false);
        $(".info-consultaSinExamenes").fadeIn("slow");
        turnInput(".examenSelect", false);
        $(".examenSelect").fadeIn("slow");

        const consultaTipo = document.getElementById("s-tipo_consulta")

        if (consultaTipo.value === "0" || consultaTipo.value === "2") {
            consultaEmergencia({ value: consultaTipo.value });
            // turnInput(".inputPacienteBeneficiadoEmergencia", true);
        }

        if (input.value === "consultaSinExamen") {
            turnInput(".examenSelect", true);
            $(".examenSelect").fadeOut("slow");
        }
    }
}

window.tipoConsultaSelect = tipoConsultaSelect;