import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";

const disabledInputs = document.querySelectorAll(".form-control[disabled]");

$("#s-tipo_paciente").on("change", function (e) {

    disabledInputs.forEach(el => {
        if (e.target.value == 2 || e.target.value == 3) {
            el.disabled = false;
        } else {
            el.disabled = true;
        }
    })
})

async function addPaciente() {

    const $form = document.getElementById("info-paciente"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {},
            seguro = [];

        formData.forEach((value, key) => (data[key] = value));

        data.telefono = data.cod_tel + data.telefono;

        let edad = data.fecha_nacimiento.split("-");
        data.edad = getAge(edad[0], edad[1], edad[2]);

        let seguros = formData.getAll("seguro[]");
        seguros.forEach(e => {
            const seguro_id = {
                seguro_id: e,
                empresa_id: data.empresa_id,
                tipo_seguro: data.tipo_seguro,
                cobertura_general: data.cobertura_general,
                fecha_contra: data.fecha_contra,
                saldo_disponible: data.saldo_disponible
            }
            seguro.push(seguro_id);
        })

        data.seguro = seguro;

        // TODO: Validar los inputs del paciente

        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        await addModule("pacientes","info-paciente",data,"Paciente registrado correctamente!");

        $('#pacientes').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addPaciente = addPaciente;

