function examenHechoAqui(inputRadio, input, label){
    
    const precioExamen = document.getElementById(input);
    const precioExamenLabel = document.getElementById(label);
    
    if(inputRadio.value === "1"){
        precioExamen.disabled = false;
        $(precioExamen).fadeIn("slow");
        $(precioExamenLabel).fadeIn("slow");
    } else {
        $(precioExamen).fadeOut("slow");
        $(precioExamenLabel).fadeOut("slow");
        precioExamen.disabled = true;
    }
}

window.examenHechoAqui = examenHechoAqui;