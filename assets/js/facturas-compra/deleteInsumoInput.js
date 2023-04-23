function deleteInsumoInput(input){

    const insumoContainer = input.parentElement.parentElement,
        precioUnitario = insumoContainer.querySelector("input[name='precio_unit']"),
        unidades = insumoContainer.querySelector("input[name='unidades']");

        precioUnitario.value = 0;
        unidades.value = 0;
        precioUnitario.dispatchEvent(new Event('input', { bubbles: true }));
        unidades.dispatchEvent(new Event('input', { bubbles: true }));


    insumoContainer.remove();
}

window.deleteInsumoInput = deleteInsumoInput;


// Todavia trabajando pera xd