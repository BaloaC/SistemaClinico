import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import getAll from "../global/getAll.js";
import { patterns } from "../global/patternsValidation.js";
import { empresasPagination } from "./empresasPagination.js";
import { mostrarEmpresas } from "./mostrarEmpresas.js";

async function addEmpresa() {
    const $form = document.getElementById("info-empresa"),
        alert = document.querySelector(".alert")

    try {
        const formData = new FormData($form),
            data = {},
            seguro = [];

        formData.forEach((value, key) => (data[key] = value));

        let seguros = formData.getAll("seguro[]");
        seguros.forEach(e => {
            const seguro_id = {
                seguro_id: e
            }
            seguro.push(seguro_id);
        })

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };
        if (data.nombre.length < 6) throw { message: "El nombre del seguro debe contener al menos 6 caracteres"};
        if (!(patterns.nameCompany.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        if (!(patterns.address.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };

        data.seguro = seguro;
        data.rif = data.cod_rif + "-" + data.rif;

        await addModule("empresas", "info-empresa", data, "Empresa registrada exitosamente!");

        const listadoEmpresas = await getAll("empresas/consulta");
        empresasPagination(listadoEmpresas);
        cleanValdiation("info-empresa")
        $("#s-seguro").val([]).trigger('change');

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        alert.textContent = error.message || error.result.message;
    }
}

window.addEmpresa = addEmpresa;
document.getElementById("info-empresa").addEventListener('submit', event => {
    event.preventDefault();
    addEmpresa();
})

