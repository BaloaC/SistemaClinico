import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";

async function addFMedico() {

    const $form = document.getElementById("info-fmedico"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        // TODO: Validar los inputs del paciente
        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        // Obtener la fecha actual en la zona horaria local
        const fechaActual = luxon.DateTime.local();

        // Formatear la fecha en el formato deseado
        const fechaFormateada = fechaActual.toFormat('yyyy-MM-dd');

        data.fecha_actual = fechaFormateada;


        await addModule("factura/medico", "info-fmedico", data, "Factura medico registrada correctamente!");
        $('#fMedicos').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFMedico = addFMedico;

