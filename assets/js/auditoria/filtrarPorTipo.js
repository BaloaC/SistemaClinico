const disabledInputs = document.querySelectorAll(".form-control[disabled]");

document.getElementById("inputFiltro").addEventListener("change", e => {

    const subMenus = document.querySelector(".sub-menus");
    let counter = 1,
    selectedSubMenu = e.target.value;

    for (const subMenu of subMenus.children) {
        
        const subMenuInputs = subMenu.querySelectorAll("input, select");

        if((selectedSubMenu == "fecha" && counter == 1) || (selectedSubMenu == "usuario" && counter == 2) || (selectedSubMenu == "accion" && counter == 3) ){
        
            subMenuInputs.forEach(el => {
                el.disabled = false;
            });

            subMenu.classList.remove("opacity-0");
            setTimeout(() => {
                subMenu.classList.remove("d-none");
            }, 550);
            
        } else {

            subMenuInputs.forEach(el => {
                el.disabled = true;
            })

            subMenu.classList.add("opacity-0");
            setTimeout(() => {
                subMenu.classList.add("d-none");
            }, 550);
        }
        
        counter++;
    }
})
