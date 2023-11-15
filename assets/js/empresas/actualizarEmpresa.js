import { mostrarEmpresas } from "./mostrarEmpresas.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import getById from "../global/getById.js";
import { createOptionOrSelectInstead, select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import { empresasPagination } from "./empresasPagination.js";
import validateInputsOnUpdate from "../global/validateInputsOnUpdate.js";
import cleanValdiation from "../global/cleanValidations.js";
import { patterns } from "../global/patternsValidation.js";

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
            seguro = [],
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        let seguros = formData.getAll("seguro[]");
        seguros.forEach(e => {
            const seguro_id = {
                seguro_id: e
            }
            seguro.push(seguro_id);
        })

        if(seguro.length > 0) data.seguro = seguro;

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };
        if (data.nombre.length < 6) throw { message: "El nombre de la empresa debe contener al menos 6 caracteres"};
        if (!(patterns.nameCompany.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.address.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };


        const parseData = deleteSecondValue("#act-empresa input, #act-empresa select", data);

        await updateModule(parseData, "empresa_id", "empresas", "act-empresa", "Empresa actualizada correctamente!");
        const listadoEmpresas = await getAll("empresas/consulta");
        cleanValdiation("act-empresa");
        cleanValdiation("info-empresa");
        empresasPagination(listadoEmpresas);

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
document.getElementById("act-empresa").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdate();
})

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