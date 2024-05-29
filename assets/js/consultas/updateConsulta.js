import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
async function updateConsulta(id) {

    const $form = document.getElementById("act-consulta");
    
    try {

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "consulta_id";
        $form.appendChild($inputId);

    } catch (error) {
        console.log(error);
    }
}

window.updateConsulta = updateConsulta;

async function confirmUpdate() {
    const $form = document.getElementById("act-consulta"),
        $alert = document.getElementById("actAlert");

    try {

        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const parseData = deleteSecondValue("#act-consulta input, #act-consulta select", data);


        await updateModule(parseData, "consulta_id", "consulta/emergencia", "act-consulta", "Consulta actualizada exitosamente!");
        $('#consultas').DataTable().ajax.reload();


    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdate = confirmUpdate;