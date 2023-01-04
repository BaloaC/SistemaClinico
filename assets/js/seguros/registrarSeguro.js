import {mostrarSeguros} from "./mostrarSeguros.js";

const d = document;
const path = location.pathname.split('/');

d.addEventListener("click", async e => {
    if (e.target.matches("#btn-registrar")) {
        e.preventDefault();
        const $form = d.getElementById("info-seguro"),
        $alert = d.querySelector(".alert"),
        $segContainer = d.querySelector(".seg-container");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            if(isNaN(data.rif) || data.rif.length !== 9) throw {message: "El RIF ingresado es inválido"};
            
            if(!isNaN(data.cod_rif) || data.cod_rif.length !== 1) throw {message: "El RIF ingresado es inválido"};

            if(!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw {message: "El nombre ingresado no es válido"};

            if(isNaN(data.telefono) || data.telefono.length !== 7) throw {message: "El número ingresado no es válido"};
            
            if(isNaN(data.cod_tel) || data.cod_tel.length !== 4) throw {message: "El número ingresado no es válido"};

            if(isNaN(data.porcentaje)) throw {message: "El porcentaje ingresado no es válido"};

            data.telefono = data.cod_tel + data.telefono;
            data.rif = data.cod_rif + "-" + data.rif;
            
            console.log(data.cod_rif);

            const options = {

                method: "POST",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            const response = await fetch(`/${path[1]}/seguros`, options);

            let json = await response.json();

            if (!json.code) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Seguro registrado correctamente!";
            $form.reset();

            const $ul = d.createElement("ul");
            $ul.classList.add("list-seg");
            $segContainer.replaceChild($ul,$segContainer.lastElementChild);
            mostrarSeguros();

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



