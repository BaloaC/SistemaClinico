function esCobrado(select){
    if(select.value === "1"){
        document.getElementById("precioInsumo").disabled = false;
    } else {
        document.getElementById("precioInsumo").disabled = true;
        document.getElementById("precioInsumo").value = 0;
    }
}

window.esCobrado = esCobrado;