import {mostrarEmpresas} from "./mostrarEmpresas.js";

const d = document,
    path = location.pathname.split('/')

// console.log(listarSeguros());

d.addEventListener("click", async e => {
    if (e.target.matches("#btn-confirmDelete")) {
        e.preventDefault();
        const $alert = d.getElementById("delAlert"),
        $segContainer = d.querySelector(".seg-container");

        try {

            const options = {

                method: "DELETE",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
            };

            const response = await fetch(`/${path[1]}/empresas/${e.target.value}`, options);

            let json = await response.json();

            if (!json.code) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Seguro eliminado correctamente!";

            const $ul = d.createElement("ul");
            $ul.classList.add("list-seg");
            $segContainer.replaceChild($ul,$segContainer.lastElementChild);
            mostrarEmpresas();

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