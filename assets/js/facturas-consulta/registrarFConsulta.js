import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";


select2OnClick({
    selectSelector: "#s-paciente-consulta",
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    module: "pacientes/consulta",
    parentModal: "#modalRegNormal",
    placeholder: "Seleccione un paciente"
});

select2OnClick({
    selectSelector: "#s-consulta-normal",
    selectValue: "consulta_id",
    selectNames: ["consulta_id", "motivo_cita"],
    module: "consultas/consulta",
    parentModal: "#modalRegNormal",
    placeholder: "Seleccione una consulta"
});

dinamicSelect2({
    obj: [{ id: "efectivo", text: "Efectivo" }, { id: "debito", text: "Debito" }],
    selectNames: ["text"],
    selectValue: "id",
    selectSelector: "#s-metodo-pago",
    placeholder: "Seleccione un método de pago",
    parentModal: "#modalRegNormal",
    staticSelect: true
});



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

        const registroExitoso = await addModule("factura/consulta","info-fconsulta",data,"Factura consulta registrada correctamente!", "#modalRegNormal", ".alertConsulta");

        if (!registroExitoso.code) throw { result: registroExitoso.result };
        
        cleanValdiation("info-fconsulta");
        $('#fConsulta').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFConsulta = addFConsulta;

