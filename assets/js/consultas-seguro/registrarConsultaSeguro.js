import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { emptyAllSelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";

let modalOpened = false;
const modalRegister = document.getElementById("modalRegAsegurada") ?? undefined;

export const updateConsultaSeguroSelect = async (modalParent) => {
    emptyAllSelect2({
        selectSelector: "#s-consulta-seguro",
        parentModal: modalParent,
        placeholder: "Cargando"
    })

    document.getElementById("s-consulta-seguro").classList.remove("is-valid");

    const infoConsultas = await getAll("consultas/consulta");

    dinamicSelect2({
        obj: infoConsultas ?? [],
        selectSelector: `#s-consulta-seguro`,
        selectValue: "consulta_id",
        selectNames: ["consulta_id", "motivo_cita"],
        parentModal: "#modalRegAsegurada",
        placeholder: "Seleccione una consulta",
        defaultLabel: ["Consulta por emergencia"]
    });

    $("#s-consulta-seguro").val([]).trigger("change")
    document.getElementById("s-consulta-seguro").classList.remove("is-valid");
}

const handleModalOpen = async (modalParent) => {

    if(modalOpened === false){

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
    
        await updateConsultaSeguroSelect(modalParent);

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen("#modalRegAsegurada"));

async function addFSeguro() {

    const $form = document.getElementById("info-fseguro"),
        $alert = document.querySelector(".alertConsultaSeguro");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(patterns.price.test(data.monto))) throw { message: "El precio ingresado es inválido" };


        await addModule("factura/consultaSeguro", "info-fseguro", data, "La factura seguro ha sido generada correctamente!", "#modalRegAsegurada", ".alertConsultaSeguro");

        cleanValdiation("info-fseguro");
        $('#consultas').DataTable().ajax.reload();
        await updateConsultaSeguroSelect("#modalRegAsegurada");

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFSeguro = addFSeguro;

