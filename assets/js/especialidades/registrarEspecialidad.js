import addModule from "../global/addModule.js";

async function addEspecialidad() {
    const $form = document.getElementById("info-especialidad"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        await addModule("especialidades", "info-especialidad", data, "Especialidad registrada con exito!");

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

window.addEspecialidad = addEspecialidad;