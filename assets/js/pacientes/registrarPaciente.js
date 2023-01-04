import getAge from "../global/getAge.js";

const d = document,
    path = location.pathname.split('/'),
    disabledInputs = d.querySelectorAll(".form-control[disabled]");

addEventListener("change", e => {
    if (e.target.matches("#tipo_paciente")) {
        disabledInputs.forEach(el => {

            if (e.target.value == 2 || e.target.value == 3) {
                el.disabled = false;
            } else {
                el.disabled = true;
            }
        })
    }
})

d.addEventListener("click", async e => {

    if (e.target.matches("#btn-registrar")) {

        e.preventDefault();
        const $form = d.getElementById("info-paciente"),
            $alert = d.querySelector(".alert");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            data.telefono = data.cod_tel + data.telefono;

            let edad = data.fecha_nacimiento.split("-");
            data.edad = getAge(edad[0], edad[1], edad[2]);

            // TODO: Validar los inputs del paciente

            // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

            // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

            // data.rif = data.cod_rif + "-" + data.rif;

            const options = {

                method: "POST",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            const response = await fetch(`/${path[1]}/pacientes`, options),
                json = await response.json();


            if (response.status != 201) throw { result: json }

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Paciente registrado correctamente!";
            $form.reset();

            $('#pacientes').DataTable().ajax.reload();

            setTimeout(() => {
                $("#modalReg").modal("hide");
                $alert.classList.add("d-none");
            }, 500);

        } catch (error) {
            console.log(error);
            $alert.classList.remove("d-none");
            $alert.classList.add("alert-danger");
            $alert.textContent = error.message || error.result.message;
        }
    }
})



