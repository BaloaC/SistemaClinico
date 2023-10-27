import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";

async function addInsumo() {
    const $form = document.getElementById("info-insumo"),
        alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        // if (!(/^[1-9]\d*$/.test(data.cantidad)) || !(/^[1-9]\d*$/.test(data.stock)) || !(/^[1-9]\d*$/.test(data.cantidad_min))) throw { message: "Un campo númerico ingresado no es válido" };
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.precio))) throw { message: "El precio ingresado no es válido" };

        await addModule("insumos", "info-insumo", data, "Insumo registrado con exito!");
       
        cleanValdiation("info-insumo");
        $('#insumos').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        alert.textContent = error.message || error.result.message;
    }
}

window.addInsumo = addInsumo;
document.getElementsByName('precio')[0].addEventListener('keydown', (event) => {
    if (event.key == 'Enter') {
        event.preventDefault();
        addInsumo();
    }
})