export const defaultSelect = () => {
    const selects = document.querySelectorAll("select");

    if(selects?.length > 0){
        for (const select of selects) {


            // En caso de no tener la clase se la añadimos, de lo contrairo solo se le asignará el evento
            if(!select.classList.contains("default-select")){
                    
                const selectOptions = select.options;
                let selectHasOptions = selectOptions?.length > 0;
        
                // Si el primer option está vacío lo deshabilitamos por defecto
                if (selectHasOptions && selectOptions[0].value === "") {
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

