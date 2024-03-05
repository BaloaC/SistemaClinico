import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";

async function addMedicamento() {
    const $form = document.getElementById("info-medicamento"),
        alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));
        
        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!data.nombre_medicamento.length > 3) throw { message: "El nombre debe contener al menos 3 caracteres" };
        if (!(patterns.nameExam.test(data.nombre_medicamento))) throw { message: "El nombre ingresado no es válido" };
        
        const registroExitoso = await addModule("medicamento", "info-medicamento", data, "Medicamento registrado con exito!");
       
        if (!registroExitoso.code) throw { result: registroExitoso.result };

        cleanValdiation("info-medicamento");
        $('#medicamentos').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        alert.textContent = error.message || error.result.message;
    }
}

window.addMedicamento = addMedicamento;

document.getElementById("info-medicamento").addEventListener('submit', (event) => {
    event.preventDefault();
    addMedicamento();
})