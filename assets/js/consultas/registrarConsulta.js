import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";
import getById from "../global/getById.js";

async function addConsulta() {

    const $form = document.getElementById("info-consulta"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {},
            examenes = [];

        formData.forEach((value, key) => (data[key] = value));

        const infoCita = await getById("citas", data.cita_id);
        data.cedula_titular = infoCita[0].cedula_titular;
        data.especialidad_id = infoCita[0].especialidad_id;
        data.medico_id = infoCita[0].medico_id;

        let examen = formData.getAll("examenes[]");
        examen.forEach(e => {
            const examen_id = {
                examen_id: e,
            }
            examenes.push(examen_id);
        })

        if (examenes.length != 0) { data.examenes = examenes; }

        const $insumos = document.querySelectorAll(".insumo-id"),
            $insumosCant = document.querySelectorAll(".insumo-cant"),
            insumos = [];

        $insumos.forEach((value, key) => {
            const insumo = {
                insumo_id: value.value,
                cantidad: $insumosCant[key].value
            }
            insumos.push(insumo);
        })

        if (insumos.length != 0) { data.insumos = insumos; }


        // TODO: Validar los inputs del paciente

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        // if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.altura))) throw { message: "La altura no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.peso))) throw { message: "La cédula no es válida" };


        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        await addModule("consultas", "info-consulta", data, "Consulta registrada correctamente!");
        Array.from(document.getElementById("info-consulta").elements).forEach(element => {
            element.classList.remove('valid');
        })
        $('#consultas').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addConsulta = addConsulta;
document.getElementById("info-consulta").addEventListener('submit', (event) => {
    event.preventDefault();
    addConsulta();
})

