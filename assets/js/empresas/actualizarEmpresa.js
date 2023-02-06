import { mostrarEmpresas } from "./mostrarEmpresas.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";

async function updateEmpresa(id) {

    const $form = document.getElementById("act-empresa");

    try {

        const json = await getById("empresas", id);

        //Separar el rif
        let $rif = json.rif.split('-');

        //Recorrer las lista de opciones y seleccionar la que coincida (static select)
        for (const option of $form.cod_rif.options) {
            if (option.value === $rif[0]) {
                option.defaultSelected = true;
            }
        }

        json.seguro.forEach(el => {
            createOptionOrSelectInstead({
                obj: el,
                selectSelector: "#s-seguro-update",
                selectNames: ["nombre"],
                selectValue: "seguro_id"
            });
        });
        
        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre;
        $form.nombre.dataset.secondValue = json.nombre;
        $form.rif.value = $rif[1];
        $form.rif.dataset.secondValue = $rif[1];
        $form.cod_rif.dataset.secondValue = $rif[0];
        $form.direccion.value = json.direccion;
        $form.direccion.dataset.secondValue = json.direccion;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "empresa_id";
        $form.appendChild($inputId);

    } catch (error) {

        console.log(error);
    }
}

window.updateEmpresa = updateEmpresa;

async function confirmUpdate() {
    const $form = document.getElementById("act-empresa"),
        $alert = document.getElementById("actAlert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));
        data.seguro = formData.getAll("seguro[]");
        
        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        const parseData = deleteSecondValue("#act-empresa input, #act-empresa select", data);

        await updateModule(parseData, "empresa_id", "empresas", "act-empresa", "Empresa actualizada correctamente!");
        mostrarEmpresas();

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

select2OnClick({
    selectSelector: "#s-seguro-update",
    selectValue: "seguro_id",
    selectNames: ["nombre"],
    module: "seguros/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione un seguro",
    selectWidth: "100%",
    multiple: true
});