function toggleAddTitular(value) {

    const newTitular = document.querySelectorAll(".new-titular-input");
    const newTitularContent = document.querySelectorAll(".new-titular-input > *");
    const newTitularTitle = document.getElementById("new-titular-title");
    const btnAddTitular = document.getElementById("btn-add-titular");
    const btnHideTitular = document.getElementById("btn-hide-titular");
    const modalActContent = document.getElementById("modalActBody");

    if (value === "show") {

        // Ocultamos el boton y mostramos el de ocultar unicamente
        $(btnAddTitular).fadeOut("slow");
        $(btnHideTitular).fadeIn("slow");

        $(newTitularTitle).fadeIn("slow");
        $(newTitular).fadeIn("slow");

        for (const newTitular of newTitularContent) {
            $(newTitular).fadeIn("slow");
            newTitular.disabled = false;
        }

        // Bajar el scroll hacia abajo luego de mostrar todo el contenido
        modalActContent.scrollTo({
            top: modalActContent.scrollHeight,
            bottom: 0, 
            behavior: 'smooth'
        });

    } else {

        // Ocultamos el boton y mostramos el de mostrar unicamente
        $(btnHideTitular).fadeOut("slow");
        $(btnAddTitular).fadeIn("slow");

        $(newTitularTitle).fadeOut("slow");
        $(newTitular).fadeOut("slow");

        for (const newTitular of newTitularContent) {
            $(newTitular).fadeOut("slow");
            newTitular.disabled = true;
        }
    }
}

window.toggleAddTitular = toggleAddTitular;