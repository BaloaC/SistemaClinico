import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";

async function addInsumo() {
    const $form = document.getElementById("info-insumo"),
        alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre.length > 3) throw { message: "El nombre de contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.price.test(data.cantidad)) && !(patterns.price.test(data.cantidad_min))) throw { message: "Un campo númerico ingresado no es válido" };
        if (!(patterns.price.test(data.precio))) throw { message: "El precio ingresado no es válido" };

        const registroExitoso = await addModule("insumos", "info-insumo", data, "Insumo registrado con exito!");
       
        if (!registroExitoso.code) throw { result: registroExitoso.result };

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