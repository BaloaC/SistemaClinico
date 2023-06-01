import addModule from "../global/addModule.js";

async function addMedicamento() {
    const $form = document.getElementById("info-medicamento"),
        alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));
        
        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        await addModule("medicamento", "info-medicamento", data, "Medicamento registrado con exito!");
        Array.from(document.getElementById("info-medicamento").elements).forEach(element => {
            element.classList.remove('valid');
        })
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