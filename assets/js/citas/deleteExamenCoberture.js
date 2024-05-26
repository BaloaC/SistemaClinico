function deleteExamenCoberture(examen_id) {

    const montoDisponible = document.getElementById("montoDisponible");
    let montoDisponibleTotal = parseFloat(montoDisponible.innerText.split("$")[1]);
    const examenCobertureContainer = document.querySelector(`.examen_id_${examen_id}`);
    const mensajeCobertureContainer = document.querySelector(`.examen_id_mensaje_${examen_id}`);
    const examenCobertureElements = examenCobertureContainer.querySelectorAll("td");
    const inputExamen = examenCobertureElements[1].lastChild;

    const examenPrice = parseFloat(examenCobertureElements[2].lastChild.nodeValue.slice(1));

    // Si el el examen se seleccionó para cobertura regresar el monto del examen al total
    if(examenCobertureElements[1].childNodes[0].checked){
        montoDisponible.innerText = `Saldo a favor: $${montoDisponibleTotal += examenPrice}`;
    }

    // Si ya no quedan más elementos ocultar la tabla de los exámenes y mostrar el mensaje
    if(document.querySelectorAll(".examen_mensaje").length <= 1){

        $(".examenesCitaContainer").fadeOut("slow");
        $("#sinExamenesCita").fadeIn("slow");
    } else {

        $("#sinExamenesCita").fadeOut("slow");
        $(".examenesCitaContainer").fadeIn("slow");
    }

    // Eliminamos el examen
    $(examenCobertureContainer).fadeOut("slow");
    inputExamen.classList.add("deleted");
    mensajeCobertureContainer.remove();
    
    
}

window.deleteExamenCoberture = deleteExamenCoberture;