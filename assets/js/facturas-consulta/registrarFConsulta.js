import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";

async function addFConsulta() {

    const $form = document.getElementById("info-fconsulta"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        // TODO: Validar los inputs del paciente

        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        await addModule("factura/consulta","info-fconsulta",data,"Factura consulta registrada correctamente!");
        $('#fConsulta').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFConsulta = addFConsulta;

