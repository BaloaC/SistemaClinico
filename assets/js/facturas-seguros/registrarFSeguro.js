import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAge from "../global/getAge.js";

async function addFSeguro() {

    const $form = document.getElementById("info-fseguro"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto))) throw { message: "El precio ingresado es inválido" };


        await addModule("factura/seguro","info-fseguro",data,"Factura seguro registrada correctamente!");

        cleanValdiation("info-fseguro");
        $('#fSeguros').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFSeguro = addFSeguro;

