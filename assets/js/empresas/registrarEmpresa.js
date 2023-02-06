import addModule from "../global/addModule.js";
import { mostrarEmpresas } from "./mostrarEmpresas.js";

async function addEmpresa() {
    const $form = document.getElementById("info-empresa"),
        $alert = document.querySelector(".alert")

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
        
        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };
        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };
        

        data.seguro = seguro;
        data.rif = data.cod_rif + "-" + data.rif;

        

        await addModule("empresas", "info-empresa", data, "Empresa registrada exitosamente!");
        mostrarEmpresas();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addEmpresa = addEmpresa;

