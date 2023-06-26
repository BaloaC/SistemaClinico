export default function parseCitas(citas) {
    try {
        const allCitas = [];

        citas.forEach((el) => {
            console.log(`${el.fecha_cita.replace(" ", "T")}${el.hora_entrada}`);
            let cita = {
                color: (el.tipo_cita === "1") ? "blue" : "black",
                allDay: 0,
                id: el.cita_id,
                start: `${el.fecha_cita}T${el.hora_entrada}`,
                end: `${el.fecha_cita}T${el.hora_salida}`,
                extendedProps: el,
                title: el.motivo_cita
            }
            allCitas.push(cita);
        })

        return allCitas;

    } catch (error) {

        console.log(error);
    }
}