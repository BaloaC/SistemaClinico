export default function forzarCitasHorario(input) {

    console.log(`aa`)

    if (input.value === "true") {

        // const horaEntradaElements = document.querySelectorAll(`.hora_entrada_${input.dataset.modaltarget}`);
        // const horaSalidaElements = document.querySelectorAll(`.hora_salida_${input.dataset.modaltarget}`);

        // if (horaEntradaElements.length > 0) {
        //     horaEntradaElements[0].disabled = false;
        //     horaEntradaElements[1].disabled = false;
        // }

        // if (horaSalidaElements.length > 0) {
        //     horaSalidaElements[0].disabled = false;
        //     horaSalidaElements[1].disabled = false;
        // }

        document.querySelectorAll(`.hora_entrada_${input.dataset.modaltarget}`)[0].disabled = false;
        document.querySelectorAll(`.hora_entrada_${input.dataset.modaltarget}`)[1].disabled = false;
        document.querySelectorAll(`.hora_salida_${input.dataset.modaltarget}`)[0].disabled = false;
        document.querySelectorAll(`.hora_salida_${input.dataset.modaltarget}`)[1].disabled = false;

    } else {

        document.querySelectorAll(`.hora_entrada_${input.dataset.modaltarget}`)[0].disabled = true;
        document.querySelectorAll(`.hora_entrada_${input.dataset.modaltarget}`)[1].disabled = true;
        document.querySelectorAll(`.hora_salida_${input.dataset.modaltarget}`)[0].disabled = true;
        document.querySelectorAll(`.hora_salida_${input.dataset.modaltarget}`)[1].disabled = true;
    }
}

window.forzarCitasHorario = forzarCitasHorario;