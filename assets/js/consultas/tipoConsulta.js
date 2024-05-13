function turnInput(container, disabled) {
    const containerParent = document.querySelector(container);
    const elements = containerParent.querySelectorAll("input, select");
    elements.forEach((element) => {
        element.disabled = disabled;
    });
}

async function tipoConsulta(input){
    if(input.value === "consulta"){
        turnInput(".info-examenes", true);
        $(".info-examenes").fadeOut("slow");
        turnInput(".info-consultaSinExamenes", false);
        $(".info-consultaSinExamenes").fadeIn("slow");
    } else {
        turnInput(".info-consultaSinExamenes", true);
        $(".info-consultaSinExamenes").fadeOut("slow");
        turnInput(".info-examenes", false);
        $(".info-examenes").fadeIn("slow");
    }
}

window.tipoConsulta = tipoConsulta;