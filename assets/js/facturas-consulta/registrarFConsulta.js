import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";

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
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto_consulta_usd))) throw { message: "El monto ingresado en usd es inválido" };

        const registroExitoso = await addModule("factura/consulta","info-fconsulta",data,"El recibo consulta ha generado correctamente!", "#modalRegNormal", ".alertConsulta");

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

