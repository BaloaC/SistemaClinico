function turnInput(container, disabled) {
    const containerParent = document.querySelector(container);
    const elements = containerParent.querySelectorAll("input, select");
    elements.forEach((element) => {
        element.disabled = disabled;
    });
}

async function tipoConsultaSelect(input){
    if(input.value === "examen"){
        turnInput(".info-consultaSinExamenes", true);
        $(".info-consultaSinExamenes").fadeOut("slow");
        turnInput(".info-examenes", false);
        $(".info-examenes").fadeIn("slow");
    } else {
        turnInput(".info-examenes", true);
        $(".info-examenes").fadeOut("slow");
        turnInput(".info-consultaSinExamenes", false);
        $(".info-consultaSinExamenes").fadeIn("slow");
    }
}

window.tipoConsultaSelect = tipoConsultaSelect;