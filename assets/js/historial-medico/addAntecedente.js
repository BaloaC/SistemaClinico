import addModule from "../global/addModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";



async function addAntecedente() {

    const id = location.pathname.split("/")[4];

    const $form = document.getElementById("info-antecedente"),
        alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        data.paciente_id = id;

        console.log(data);
        
        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        await addModule("antecedentes", "info-antecedente", data, "Antecedente registrado con exito!");
        Array.from(document.getElementById("info-antecedente").elements).forEach(element => {
            element.classList.remove('valid');
        })
        mostrarHistorialMedico(id);

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        alert.textContent = error.message || error.result.message;
    }
}

window.addAntecedente = addAntecedente;

document.getElementById("info-antecedente").addEventListener('submit', (event) => {
    event.preventDefault();
    addAntecedente();
})