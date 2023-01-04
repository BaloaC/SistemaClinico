import getAge from "../global/getAge.js";
import { listarPacientePorId } from "./listarPacientes.js";

const d = document,
    path = location.pathname.split('/');

addEventListener("click", async e => {

    if (e.target.matches(".act-paciente")) {

        e.preventDefault();
        const $form = d.getElementById("act-paciente");

        try {

            const json = await listarPacientePorId(e.target.dataset.id)

            console.log(json);

            // Obtener código telefónico
            let $telCod = json.telefono.slice(0, 4),
                $tel = json.telefono.split($telCod);

            for (const option of $form.cod_tel.options) {
                if (option.value === $telCod) {
                    option.defaultSelected = true;
                }
            }

            for (const option of $form.tipo_paciente.options) {
                if (option.value === json.tipo_paciente) {
                    option.defaultSelected = true;
                }
            }

            //Establecer el option con los datos del usuario
            $form.nombres.value = json.nombres || json.nombre_paciente;
            // $form.nombres.dataset.secondValue = json.nombres || json.nombre_paciente;
            $form.apellidos.value = json.apellidos;
            // $form.apellidos.dataset.secondValue = json.apellidos;
            $form.cedula.value = json.cedula;
            $form.cedula.dataset.secondValue = json.cedula;
            $form.fecha_nacimiento.value = json.fecha_nacimiento;
            // $form.fecha_nacimiento.dataset.secondValue = json.fecha_nacimiento;
            $form.direccion.value = json.direccion;
            // $form.direccion.dataset.secondValue = json.direccion;
            $form.telefono.value = $tel[1];
            // $form.telefono.dataset.secondValue = $tel[1];
            // $form.cod_tel.dataset.secondValue = $telCod;

            const $inputId = d.createElement("input");
            $inputId.type = "hidden";
            $inputId.value = e.target.dataset.id;
            $inputId.name = "paciente_id";
            $form.appendChild($inputId);

        } catch (error) {

            console.log(error);
        }
    }

    if (e.target.matches("#btn-actualizarInfo")) {

        e.preventDefault();
        const $form = d.getElementById("act-paciente"),
            $alert = d.getElementById("actAlert");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            let $tel = data.cod_tel + data.telefono;

            let edad = data.fecha_nacimiento.split("-");
            data.edad = getAge(edad[0], edad[1], edad[2]);

            const inputs = d.querySelectorAll("#act-paciente input, #act-paciente select");

            inputs.forEach(e => {

                if (e.dataset.secondValue === e.value) {
                    console.log(e.dataset.secondValue, e.value)
                    delete data[e.name];
                }
            })

            // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
            if ('telefono' in data || 'cod_tel' in data) { data.telefono = $tel }

            console.log(data);

            const options = {

                method: "PUT",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            // TODO: Arreglar endpoint de actualizar paciente
            const response = await fetch(`/${path[1]}/pacientes/${data.paciente_id}`, options);

            let json = await response.json();

            // TODO: Validamos con el response que sea status 200 y en caso de que no sea, retornamos la respuesta sin errores, pero habría que arreglar que se pueda validar con el json. Ahorita no se puede porque trae un error de undefined index desde el endpoint
            if (response.status != 200) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Paciente actualizado correctamente!";
            $form.reset();

            $('#pacientes').DataTable().ajax.reload();

            setTimeout(() => {
                $("#modalAct").modal("hide");
                $alert.classList.add("d-none");
            }, 500);

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
})