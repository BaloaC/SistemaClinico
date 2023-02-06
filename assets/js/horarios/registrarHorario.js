const d = document,
    path = location.pathname.split('/');

addEventListener("click", async e => {

    if (e.target.matches("#btn-registrar")) {

        e.preventDefault();
        const $form = d.getElementById("info-especialidad"),
            $alert = d.querySelector(".alert");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

            const options = {

                method: "POST",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            const response = await fetch(`/${path[1]}/especialidades`, options),
                json = await response.json();


            if (response.status != 201) throw { result: json }

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Especialidad registrado correctamente!";
            $form.reset();

            $('#especialidades').DataTable().ajax.reload();

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