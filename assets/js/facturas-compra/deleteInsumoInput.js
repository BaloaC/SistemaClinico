function deleteInsumoInput(input) {

    const inputInsumos = document.querySelectorAll(".insumo-id");

    const insumoContainer = input.parentElement.parentElement.parentElement,
        precioUnitario = insumoContainer.querySelector("input[name='precio_unit']"),
        unidades = insumoContainer.querySelector("input[name='unidades']");

    precioUnitario.value = 0;
    unidades.value = 0;
    precioUnitario.dispatchEvent(new Event('input', { bubbles: true }));
    unidades.dispatchEvent(new Event('input', { bubbles: true }));

    insumoContainer.remove();

    if (inputInsumos.length === 2) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector(".visible").classList.add("d-none")
    }
}

window.deleteInsumoInput = deleteInsumoInput;