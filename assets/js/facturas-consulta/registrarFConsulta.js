import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";

async function addFConsulta() {

    const $form = document.getElementById("info-fconsulta"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto_sin_iva))) throw { message: "El monto sin iva ingresado es inválido" };
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto_con_iva))) throw { message: "El monto con iva ingresado es inválido" };


        await addModule("factura/consulta","info-fconsulta",data,"Factura consulta registrada correctamente!");
        $('#fConsulta').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFConsulta = addFConsulta;

