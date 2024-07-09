function dateBeforeToday(input) {
    const inputFecha = input;
    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Asegúrate de que solo se compare la fecha sin la hora
    const fechaIngresada = new Date(inputFecha.value);

    if (fechaIngresada > hoy) {
        // Si la fecha ingresada es mayor a la fecha actual, establece la fecha actual
        inputFecha.valueAsDate = hoy;
    }
}

window.dateBeforeToday = dateBeforeToday;