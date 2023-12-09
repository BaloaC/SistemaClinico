import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";


select2OnClick({
    selectSelector: "#s-seguro",
    selectValue: "seguro_id",
    selectNames: ["rif", "nombre"],
    module: "seguros/consulta",
    parentModal: "#modalRegNormal",
    placeholder: "Seleccione un seguro"
});

select2OnClick({
    selectSelector: "#s-consultas",
    selectValue: "consulta_seguro_id",
    selectNames: ["consulta_seguro_id", "tipo_servicio", "fecha_ocurrencia"],
    module: "factura/consultaSeguro/consulta",
    parentModal: "#modalRegNormal",
    placeholder: "Seleccione alguna consulta",
    multiple: true
});



// dinamicSelect2({
//     obj: [{ id: "efectivo", text: "Efectivo" }, { id: "debito", text: "Debito" }],
//     selectNames: ["text"],
//     selectValue: "id",
//     selectSelector: "#s-metodo-pago",
//     placeholder: "Seleccione un método de pago",
//     parentModal: "#modalRegNormal",
//     staticSelect: true
// });



// function calcularIva(montoInput) {

//     let montoTotal = (parseFloat(montoInput.value) * 0.16) + parseFloat(montoInput.value);
//     document.getElementById("monto_con_iva").value = montoTotal.toFixed(2);
// }

// window.calcularIva = calcularIva;

async function addFMensajeria() {

    const $form = document.getElementById("info-fconsulta"),
        $alert = document.querySelector(".alertConsulta");

    try {
        const formData = new FormData($form),
            consultas = [],
            data = {};
            

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
       
        let consultasSeguro = formData.getAll("consulta_seguro_id[]");

        consultasSeguro.forEach(e => {
            const consultaSeguro = {
                consulta_seguro_id: e
            }
            consultas.push(consultaSeguro);
        })

        data.consultas = consultas;

        const registroExitoso = await addModule("factura/mensajeria","info-fconsulta",data,"Factura mensajeria registrada correctamente!", "#modalRegNormal", ".alertConsulta");

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

window.addFMensajeria = addFMensajeria;

