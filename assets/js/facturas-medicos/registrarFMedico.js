import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAll from "../global/getAll.js";

async function addFMedico() {

    const $form = document.getElementById("info-fmedico"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        // Obtener la fecha actual en la zona horaria local
        const fechaActual = luxon.DateTime.local();

        // Formatear la fecha en el formato deseado
        const fechaFormateada = fechaActual.minus({ days: 1 }).toFormat('yyyy-MM-dd');

        const facturaMedico = {
            fecha_actual: fechaFormateada,
            medico_id: data.medico_id
        }

        // const facturaMedico = await getAll(`facturaMedico/medico?fecha=${fechaFormateada}&medico=${data.medico_id}`);

        const registroExitoso = await addModule("facturas/all", "info-fmedico", facturaMedico, "Factura médico registrada correctamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        cleanValdiation("info-fmedico");
        $('#fMedicos').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFMedico = addFMedico;

