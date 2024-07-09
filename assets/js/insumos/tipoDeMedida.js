function tipoDeMedidaHandler(select) {
    let mensaje = "";

    switch (select.value) {
        case "1": mensaje = "La capacidad es por metro"; break;
        case "2": mensaje = "La capacidad es por mililitro"; break;
        case "3": mensaje = "La capacidad de la caja son unidades"; break;
        case "4": mensaje = "La capacidad es por unidades"; break;
    }

    document.querySelector(`.mensaje-medida`).innerText = mensaje;
}

window.tipoDeMedidaHandler = tipoDeMedidaHandler;