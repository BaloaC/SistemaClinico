import cleanValdiation from "../global/cleanValidations.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import { patterns } from "../global/patternsValidation.js";
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import scrollTo from "../global/scrollTo.js";
import getGlobalValues from "../global/getGlobalValues.js";

const d = document,
    path = location.pathname.split('/');


async function updatePercentage() {

    try {

        const currentPercentage = document.getElementById("medicPercentage").textContent.slice(0, -1);
        document.getElementById("porcentajeMedicoInput").value = currentPercentage;

    } catch (error) {

        console.log(error);
    }
}

window.updatePercentage = updatePercentage;

async function confirmUpdatePercentage() {
    const form = document.getElementById("act-cambioPorcentaje"),
        alert = document.getElementById("actAlertPercentage");

    try {
        const formData = new FormData(form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!form.checkValidity()) { form.reportValidity(); return; }
        if (!(patterns.price.test(data.porcentaje_medico))) throw { message: "El valor debe ser númerico y sin números negativos" };

        const parseData = deleteSecondValue("#act-cambioPorcentaje input, #act-cambioPorcentaje select", data);

        const options = {

            method: "PUT",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify({ porcentaje_medico: parseData.porcentaje_medico })
        };

        const currentPercentage = document.getElementById("medicPercentage").textContent.slice(0, -1);

        // Validamos que si el porcentaje es igual, no hacer la petición
        if (currentPercentage != parseData.cambio_divisa){
            
            let response = await fetch(`/${path[1]}/porcentajeMedico`, options)
            const json = await response.json();
    
            if (!json.code) throw { result: json };
        }


        alert.classList.remove("alert-danger");
        alert.classList.add("alert-success");
        alert.classList.remove("d-none");
        alert.textContent = "Porcentaje actualizado correctamente!";
        form.reset();
        scrollTo("modalActBodyPercentage");

        setTimeout(() => {
            $("#modalActPercentage").modal("hide");
            alert.classList.add("d-none");
        }, 750);

        cleanValdiation("act-cambioPorcentaje");
        await getGlobalValues();
        $('#especialidades').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        alert.classList.remove("d-none");
        alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        alert.textContent = message;

        setTimeout(() => {
            alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdatePercentage = confirmUpdatePercentage;
document.getElementById("act-cambioPorcentaje").addEventListener('submit', (event) => {
    event.preventDefault();
    confirmUpdatePercentage();
})