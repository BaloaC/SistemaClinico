import { mostrarSeguros } from "./mostrarSeguros.js";

const d = document,
    path = location.pathname.split('/');

d.addEventListener("click", async e => {
    if (e.target.matches("#btn-actualizarInfo")) {
        e.preventDefault();
        const $form = d.getElementById("act-seguro"),
            $alert = d.getElementById("actAlert"),
            $segContainer = d.querySelector(".seg-container");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

            if (!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw { message: "El RIF ingresado es inválido" };

            if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

            if (isNaN(data.telefono) || data.telefono.length !== 7) throw { message: "El número ingresado no es válido" };

            if (isNaN(data.cod_tel) || data.cod_tel.length !== 4) throw { message: "El número ingresado no es válido" };

            if (isNaN(data.porcentaje)) throw { message: "El porcentaje ingresado no es válido" };

            let $tel = data.cod_tel + data.telefono,
                $rif = data.cod_rif + "-" + data.rif;

            const inputs = d.querySelectorAll("#act-seguro input, #act-seguro select");

            inputs.forEach(e => {

                if (e.dataset.secondValue === e.value) {
                    console.log(e.dataset.secondValue, e.value)
                    delete data[e.name];
                }
            })

            // ** Si no existe rif o cod_rif en la data, añadirle el rif completo
            if ('rif' in data || 'cod_rif' in data) { data.rif = $rif }

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

            const response = await fetch(`/${path[1]}/seguros/${data.seguro_id}`, options);

            let json = await response.json();

            if (!json.code) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Seguro actualizado correctamente!";
            $form.reset();

            const $ul = d.createElement("ul");
            $ul.classList.add("list-seg");
            $segContainer.replaceChild($ul, $segContainer.lastElementChild);
            mostrarSeguros();

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