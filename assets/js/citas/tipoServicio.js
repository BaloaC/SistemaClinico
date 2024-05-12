export default async function tipoServicio(inputRadio) {

    const examenSelect = document.getElementById("s-examen");
    const examenInputContainer = document.querySelector(".examenInput");

    console.log(inputRadio);

    if (inputRadio.value === "1" || inputRadio.value === "2") {
        examenSelect.disabled = false;
        $(examenInputContainer).fadeIn("slow");
    } else {
        examenSelect.disabled = true;
        $(examenInputContainer).fadeOut("slow");
    }
}

// En caso de abrir el modal y con la opción del examen seleccionada, habilitar los exámenes
document.getElementById("modalReg").addEventListener("show.bs.modal", () => {

    const examenInputChecked = document.getElementById("tipoServicioExamen");
    const consultaExamenInputChecked = document.getElementById("tipoServicioConsulta");

    if (examenInputChecked.checked || consultaExamenInputChecked.checked) {

        const examenSelect = document.getElementById("s-examen");
        const examenInputContainer = document.querySelector(".examenInput");

        examenSelect.disabled = false;
        $(examenInputContainer).fadeIn("slow");
    }

})


window.tipoServicio = tipoServicio;
