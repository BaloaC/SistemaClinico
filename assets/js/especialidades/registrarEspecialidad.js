import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";

async function addEspecialidad() {
    const $form = document.getElementById("info-especialidad"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(patterns.name.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (data.nombre.length < 6) throw { message: "El nombre ingresado debe ser mayor a 6 caracteres" };

        const registroExitoso = await addModule("especialidades", "info-especialidad", data, "Especialidad registrada con exito!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        cleanValdiation("info-especialidad");
        $('#especialidades').DataTable().ajax.reload();

        setTimeout(() => {
            $("#modalReg").modal("hide");
            $alert.classList.add("d-none");
        }, 500);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addEspecialidad = addEspecialidad;
document.getElementById("info-especialidad").addEventListener('submit', (event) => {
    event.preventDefault()
    addEspecialidad();
})