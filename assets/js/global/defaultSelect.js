export const defaultSelect = () => {
    const selects = document.querySelectorAll("select");

    if(selects?.length > 0){
        for (const select of selects) {

            const selectOptions = select.options;
            let selectHasOptions = selectOptions?.length > 0;
    
            // Si el select está vacio por defecto le añadimos la clase por defecto
            if(select.value === ""){
                
                if (selectHasOptions) {
                    selectOptions[0].disabled = true;
                }
                select.classList.add("default-select");
            }
        
            // Evento para que cuando cambie de valor distinto se le quite la clase por defecto
            select.addEventListener("change", () => {
                if (select.value !== "") {
                    select.classList.remove("default-select");
                } else {
                    if(selectHasOptions){
                        selectOptions[0].disabled = true;
                        selectOptions[0].selected = true;
                    }
                    select.classList.add("default-select");
                }
            })
        }
    }
}

defaultSelect();

