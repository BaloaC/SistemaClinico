import deleteSecondValue from "../global/deleteSecondValue.js";
import updateModule from "../global/updateModule.js";
import { calendar } from "./calendarioCitas.js";

async function confirmUpdate() {
    const $form = document.getElementById("act-cita"),
        $alert = document.getElementById("actAlert");

    try {

        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const parseData = deleteSecondValue("#act-cita input, #act-cita select", data);

        const examenes = document.querySelectorAll(".examenCubierto");
        const examenesCita = [];

        examenes.forEach(examen => {

            console.log(examen, examen.dataset.id);

            const checkboxesCubiertos = document.querySelectorAll(`.examenCita${examen.dataset.id}`);
            
            let cubiertoPor = 3;

            if(checkboxesCubiertos[0].checked && checkboxesCubiertos[1].checked){
                cubiertoPor = 3;
            } else if (checkboxesCubiertos[0].checked ){
                cubiertoPor = 1;
            } else if (checkboxesCubiertos[1].checked){
                cubiertoPor = 2;
            } 

            let examenCita = {
                cita_examen_id: examen.dataset.id,
                cubierto_por: cubiertoPor
            }

            examenesCita.push(examenCita);
        })

        parseData.cita_examenes = examenesCita;
        
        console.log(parseData);
        
        await updateModule(parseData, "cita_id", "citas", "act-cita", "Cita actualizada exitosamente!");
        calendar.refetchEvents();

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

window.confirmUpdate = confirmUpdate;