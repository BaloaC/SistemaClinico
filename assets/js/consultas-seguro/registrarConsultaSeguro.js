import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";

select2OnClick({
    selectSelector: "#s-consulta-seguro",
    selectValue: "consulta_id",
    selectNames: ["consulta_id", "motivo_cita"],
    module: "consultas/consulta",
    parentModal: "#modalRegAsegurada",
    placeholder: "Seleccione una consulta"
});

dinamicSelect2({
    obj: [{ id: "consulta", text: "Consulta" }, { id: "laboratorio", text: "Laboratorio" }],
    selectNames: ["text"],
    selectValue: "id",
    selectSelector: "#s-tipo-servicio",
    placeholder: "Seleccione un tipo de servicio",
    parentModal: "#modalRegAsegurada",
    staticSelect: true,
    selectWidth: "100%"
});

async function addFSeguro() {

    const $form = document.getElementById("info-fseguro"),
        $alert = document.querySelector(".alertConsultaSeguro");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[0-9]*\.?[0-9]+$/.test(data.monto))) throw { message: "El precio ingresado es inválido" };


        await addModule("factura/consultaSeguro","info-fseguro",data,"Factura seguro registrada correctamente!","#modalRegAsegurada", ".alertConsultaSeguro");
        
        cleanValdiation("info-fseguro");
        $('#consultas').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFSeguro = addFSeguro;

