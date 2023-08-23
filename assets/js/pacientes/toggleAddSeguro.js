function toggleAddSeguro(value) {

    const newSeguro = document.querySelectorAll(".new-seguro-input");
    const newSeguroContent = document.querySelectorAll(".new-seguro-input > *");
    const newSeguroTitle = document.getElementById("new-seguro-title");
    const btnAddSeguro = document.getElementById("btn-add-seguro");
    const btnHideSeguro = document.getElementById("btn-hide-seguro");
    const modalActContent = document.getElementById("modalActContent");

    if (value === "show") {

        // Ocultamos el boton y mostramos el de ocultar unicamente
        $(btnAddSeguro).fadeOut("slow");
        $(btnHideSeguro).fadeIn("slow");

        $(newSeguroTitle).fadeIn("slow");
        $(newSeguro).fadeIn("slow");

        for (const newSeguro of newSeguroContent) {
            $(newSeguro).fadeIn("slow");
            newSeguro.disabled = false;
        }

        // Bajar el scroll hacia abajo luego de mostrar todo el contenido
        modalActContent.scrollTo({
            top: modalActContent.scrollHeight,
            bottom: 0, 
            behavior: 'smooth'
        });

    } else {

        // Ocultamos el boton y mostramos el de mostrar unicamente
        $(btnHideSeguro).fadeOut("slow");
        $(btnAddSeguro).fadeIn("slow");

        $(newSeguroTitle).fadeOut("slow");
        $(newSeguro).fadeOut("slow");

        for (const newSeguro of newSeguroContent) {
            $(newSeguro).fadeOut("slow");
            newSeguro.disabled = true;
        }
    }
}

window.toggleAddSeguro = toggleAddSeguro;