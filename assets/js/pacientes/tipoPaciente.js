const disabledInputs = document.querySelectorAll(".form-control[disabled]");

document.getElementById("s-tipo_paciente").addEventListener("change", e => {

    const subMenus = document.querySelector(".sub-menus");
    const modalRegContent = document.getElementById("modalRegBody");
    let counter = 1,
    selectedSubMenu = e.target.value;

    for (const subMenu of subMenus.children) {
        
        const subMenuInputs = subMenu.querySelectorAll("input, select");

        if((selectedSubMenu == 3 && counter == 2) || (selectedSubMenu == 4 && counter == 1)){
        
            subMenuInputs.forEach(el => {
                el.disabled = false;
            });

            subMenu.classList.remove("opacity-0");
            setTimeout(() => {
                subMenu.classList.remove("d-none");

                // Bajar el scroll hacia abajo luego de mostrar todo el contenido
                modalRegContent.scrollTo({
                    top: modalRegContent.scrollHeight,
                    bottom: 0, 
                    behavior: 'smooth'
                });
            }, 550);

        } else {

            subMenuInputs.forEach(el => {
                el.disabled = true;
            })

            setTimeout(() => {
                subMenu.classList.add("d-none");
            }, 550);
        }
        
        counter++;
    }
})
