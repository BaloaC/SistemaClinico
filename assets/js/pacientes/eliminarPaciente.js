const d = document,
    path = location.pathname.split('/');

addEventListener("click", async e => {

    if(e.target.matches(".del-paciente")){

        const $btnDelete = d.getElementById("btn-confirmDelete");
        $btnDelete.value = e.target.dataset.id;
    }

    if (e.target.matches("#btn-confirmDelete")) {

        e.preventDefault();
        const $alert = d.getElementById("delAlert");

        try {

            const options = {

                method: "DELETE",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
            };

            const response = await fetch(`/${path[1]}/pacientes/${e.target.value}`, options);

            let json = await response.json();

            if (!json.code) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Paciente eliminado correctamente!";

            $('#pacientes').DataTable().ajax.reload();
         
            setTimeout(() => {
                $("#modalDelete").modal("hide");
                $alert.classList.add("d-none");
            }, 500);

        } catch (error) {

            console.log(error);

            $alert.classList.remove("d-none");
            $alert.classList.add("alert-danger");
            $alert.textContent = error.result.message;

            setTimeout(() => {
                $alert.classList.add("d-none");
            }, 3000)
        }
    }
})