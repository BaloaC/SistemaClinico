const disabledInputs = document.querySelectorAll(".form-control[disabled]");

document.getElementById("inputFiltro").addEventListener("change", e => {

    const subMenus = document.getElementById("filtrarPor");
    let counter = 1,
    selectedSubMenu = e.target.value;

    // Recorremos todos los menú
    for (const subMenu of subMenus.children) {
        
        const subMenuInputs = subMenu.querySelectorAll("input, select");

        // Mostramos el menú que sea seleccionado
        if((selectedSubMenu == "submenu-fecha" && counter == 1) || (selectedSubMenu == "submenu-usuario" && counter == 2) || (selectedSubMenu == "submenu-accion" && counter == 3) ){
        
            $(subMenu).fadeIn("slow");
            subMenuInputs.forEach(el => { el.disabled = false; });

        } else {

            // Ocultamos todo menos el botón para filtrar
            if(!subMenu.classList.contains("btn")) $(subMenu).fadeOut("slow");
            
            subMenuInputs.forEach(el => { el.disabled = true; });
        }
        
        counter++;
    }
})
