const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";

export default async function addModule(module, form, data, successMessage, modal = "#modalReg", alert =".alert") {

    const $form = document.getElementById(form),
        $alert = document.querySelector(alert),
        modalActContent = document.querySelector(modal);

    try {

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
                "Authorization": "Bearer " + Cookies.get("tokken")
            },
            body: JSON.stringify(data),
        };

        const response = await fetch(`/${path[1]}/${module}`, options),
            json = await response.json();

        if (response.status != 201 && response.status != 200) throw { result: json }

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = successMessage;
        $form.reset();

        setTimeout(() => {
            $(modal).modal("hide");
            $alert.classList.add("d-none");
        }, 500);

        return json;

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 1500)

        return error;
    }

}

// d.addEventListener("click", async e => {
//     if (e.target.matches("#btn-registrar")) {

//         e.preventDefault();
//         const $form = d.getElementById("info-empresa"),
//             $alert = d.querySelector(".alert");

//         try {
//             const formData = new FormData($form),
//                 data = {};

//             formData.forEach((value, key) => (data[key] = value));

//             if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

//             if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

//             data.rif = data.cod_rif + "-" + data.rif;

//             const options = {

//                 method: "POST",
//                 mode: "cors", //Opcional
//                 headers: {
//                     "Content-type": "application/json; charset=utf-8",
//                 },
//                 body: JSON.stringify(data),
//             };

//             const response = await fetch(`/${path[1]}/empresas`, options);

//             if (response.status != 200) throw { message: "Registro inválido" }

//             // TODO: Retornar un objeto json en el endpoint registrarEmpresa y validarlo con el código de abajo
//             // let json = await response.json();;
//             // if (!json.code) throw { result: json };

//             $alert.classList.remove("alert-danger");
//             $alert.classList.add("alert-success");
//             $alert.classList.remove("d-none");
//             $alert.textContent = "Empresa registrada correctamente!";
//             $form.reset();

//             mostrarEmpresas();

//             setTimeout(() => {
//                 $("#modalReg").modal("hide");
//                 $alert.classList.add("d-none");
//             }, 500);

//         } catch (error) {
//             console.log(error);
//             $alert.classList.remove("d-none");
//             $alert.classList.add("alert-danger");
//             $alert.textContent = error.message || error.result.message;
//         }
//     }
// })



