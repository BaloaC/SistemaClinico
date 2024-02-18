import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";

function calcularIva(montoInput) {

    let montoTotal = (parseFloat(montoInput.value) * 0.16) + parseFloat(montoInput.value);
    document.getElementById("monto_con_iva").value = montoTotal.toFixed(2);
}

window.calcularIva = calcularIva;

async function addFConsulta() {

    const $form = document.getElementById("info-fconsulta"),
        $alert = document.querySelector(".alertConsulta");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto_consulta_usd))) throw { message: "El monto ingresado en usd es inválido" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto_con_iva))) throw { message: "El monto con iva ingresado es inválido" };

        // data.monto_con_iva = (parseFloat(data.monto_sin_iva) * 0.16) + parseFloat(data.monto_sin_iva)

        const registroExitoso = await addModule("factura/consulta","info-fconsulta",data,"La factura consulta ha generada correctamente!", "#modalRegNormal", ".alertConsulta");

        if (!registroExitoso.code) throw { result: registroExitoso.result };
        
        cleanValdiation("info-fconsulta");
        $('#fConsulta').DataTable().ajax.reload();
        $('#consultas').DataTable().ajax.reload();

        setTimeout(() => {
            document.getElementById("s-consulta-normal").classList.remove("is-valid");
        }, 500);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFConsulta = addFConsulta;

