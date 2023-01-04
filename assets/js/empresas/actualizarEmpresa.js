import { mostrarEmpresas } from "./mostrarEmpresas.js";
import { listarSegurosPorId } from "../seguros/listarSeguros.js";
import { listarEmpresaPorId } from "./listarEmpresas.js";

const d = document,
    path = location.pathname.split('/');

d.addEventListener("click", async e => {

    if (e.target.matches("#btn-actualizar")) {

        e.preventDefault();
        const $form = d.getElementById("act-empresa");

        try {

            const json = await listarEmpresaPorId(e.target.value),
            infoSeguro = await listarSegurosPorId(json[0].seguro_id);

            //Separar el rif
            let $rif = json[0].rif.split('-');
            
            //Recorrer las lista de opciones y seleccionar la que coincida (static select)
            for (const option of $form.cod_rif.options) {
                if (option.value === $rif[0]) {
                    option.defaultSelected = true;
                }
            }

            //Establecer el option con los datos del usuario
            $form.seguro_id.options[0].value = infoSeguro.seguro_id;
            $form.seguro_id.options[0].textContent = infoSeguro.nombre;
            $form.nombre.value = json[0].nombre_empresa;
            $form.nombre.dataset.secondValue = json[0].nombre_empresa;
            $form.rif.value = $rif[1];
            $form.rif.dataset.secondValue = $rif[1];
            $form.cod_rif.dataset.secondValue = $rif[0];
            $form.direccion.value = json[0].direccion;
            $form.direccion.dataset.secondValue = json[0].direccion;
            $form.seguro_id.dataset.secondValue = infoSeguro.seguro_id;

            const $inputId = d.createElement("input");
            $inputId.type = "hidden";
            $inputId.value = e.target.value;
            $inputId.name = "empresa_id";
            $form.appendChild($inputId);

        } catch (error) {

            console.log(error);
        }
    }

    if (e.target.matches("#btn-actualizarInfo")) {
        e.preventDefault();
        const $form = d.getElementById("act-empresa"),
            $alert = d.getElementById("actAlert"),
            $segContainer = d.querySelector(".seg-container");

        try {
            const formData = new FormData($form),
                data = {};

            formData.forEach((value, key) => (data[key] = value));

            if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

            if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };


            const inputs = d.querySelectorAll("#act-empresa input, #act-empresa select");

            inputs.forEach(e => {
                if (e.dataset.secondValue === e.value) {
                    delete data[e.name];
                }
            })

            console.log(data);
            const options = {

                method: "PUT",
                mode: "cors", //Opcional
                headers: {
                    "Content-type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(data),
            };

            const response = await fetch(`/${path[1]}/empresas/${data.empresa_id}`, options);

            let json = await response.json();

            if (!json.code) throw { result: json };

            $alert.classList.remove("alert-danger");
            $alert.classList.add("alert-success");
            $alert.classList.remove("d-none");
            $alert.textContent = "Empresa actualizado correctamente!";
            $form.reset();

            mostrarEmpresas();

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