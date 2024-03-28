const defaultOptions = { "0": "Seleccione una pregunta de seguridad", "1": "Cuál es tu color favorito", "2": "Nombre de tu mascota de la infancia", "3": "Segundo apellido de tu mamá", "4": "Apodo de la infancia", "5": "Cuál es tu pasatiempo favorito", "6": "Programa o serie de televisión favorito", "7": "Cuál era la caricatura que más te gustaba en la infancia", "8": "Algo que odies" };


const handleOnChangeSelect = (input) => {
    const selects = document.querySelectorAll(".preguntasSeguridad");



    selects.forEach(select => {

        if (select.id != input.id) {

            let selectedOptions = [];

            // Filtrar las opciones para excluir las ya seleccionadas
            selectedOptions = Array.from(selects).map(originalSelect => {

                // Validamos que el valor seleccionado sea diferente al del select y también del valor por defecto
                if (originalSelect.value != select.value && originalSelect.value != "0") {
                    return originalSelect.value;
                }
            });

            let filteredOptions = "";
            let optionValue = select.value;

            // Actualizamos los options validando que no existan en los seleccionados 
            Object.keys(defaultOptions).forEach(key => {
                if(!selectedOptions.includes(key)){
                    filteredOptions += `<option value="${key}">${defaultOptions[key]}</option>`;
                }
            });


            // Insertamos las opciones 
            select.innerHTML = filteredOptions;

            // Validamos de que si está vacío, le colocamos el valor de 0 que es el que está por defecto
            if (optionValue == "") optionValue = "0";
            
            // Deshabilitamos y establecemos el valor que tenía el select
            select.options[0].disabled = true;
            select.value = optionValue;
        }
    });
}


document.getElementById("pregunta1").addEventListener("change", (event) => handleOnChangeSelect(event.target));
document.getElementById("pregunta2").addEventListener("change", (event) => handleOnChangeSelect(event.target));
document.getElementById("pregunta3").addEventListener("change", (event) => handleOnChangeSelect(event.target));