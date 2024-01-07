import { listarHorariosPorId } from "./listarHorarios.js";

const d = document,
    path = location.pathname.split('/');

addEventListener("click", async e => {

    if (e.target.matches(".act-especialidad")) {

        e.preventDefault();
        const $form = d.getElementById("act-especialidad");

        try {

            const json = await listarHorariosPorId(e.target.dataset.id)

            //Establecer el option con los datos del usuario
            $form.nombre.value = json.nombre;
            $form.nombre.dataset.secondValue = json.nombre;

            const $inputId = d.createElement("input");
            $inputId.type = "hidden";
            $inputId.value = e.target.dataset.id;
            $inputId.name = "especialidad_id";
            // ! Para evitar error sql del endpoint
            $inputId.dataset.secondValue = e.target.dataset.id;
            $form.appendChild($inputId);

        } catch (error) {

            console.log(error);
        }
    }

    if (e.target.matches("#btn-actualizarInfo")) {

        e.preventDefault();
        const $form = d.getElementById("act-especialidad"),
            $alert = d.getElementById("actAlert");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            // ! Para evitar el error del enpoint al enviar la especialidad
            let especialidad_id = data.especialidad_id;

            const inputs = d.querySelectorAll("#act-especialidad input, #act-especialidad select");

            inputs.forEach(e => {
                if (e.dataset.secondValue === e.value) {
                    delete data[e.name];
                }
            })

            const options = {

                method: "PUT",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            if (!Object.entries(data).length == 0) {

                const response = await fetch(`/${path[1]}/especialidades/${especialidad_id}`, options);

                let json = await response.json();

                if (response.status != 200) throw { result: json };

            }

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Especialidad actualizado correctamente!";
            $form.reset();

            $('#especialidades').DataTable().ajax.reload();

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