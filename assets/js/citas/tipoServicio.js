import { emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import tipoAsegurado from "./tipoAsegurado.js";


export default async function tipoServicio(inputRadio) {

    const examenSelect = document.getElementById("s-examen");
    const examenInputContainer = document.querySelector(".examenInput");

    if (inputRadio.value === "1") {
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

    if (examenInputChecked.checked) {

        const examenSelect = document.getElementById("s-examen");
        const examenInputContainer = document.querySelector(".examenInput");

        examenSelect.disabled = false;
        $(examenInputContainer).fadeIn("slow");
    }

})


window.tipoServicio = tipoServicio;
