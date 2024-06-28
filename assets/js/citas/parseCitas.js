import getAll from "../global/getAll.js";
import getById from "../global/getById.js";
import { cachedCitas } from './cachedCitas.js';

const module = "citas";
export const citas = async () => await parseCitas(await getAll(`${module}/consulta`));

export default async function parseCitas(citas) {
    try {
        const allCitas = [];

        await Promise.all(citas.map(async (el) => {

            let citaInfo = cachedCitas.find(c => c.cita_id === el.cita_id);

            if (!citaInfo) {
                citaInfo = await getById("citas", el.cita_id);
                cachedCitas.push({...citaInfo, cita_id: el.cita_id});
            }

            let color;
            if (el.tipo_cita === "1") {
                color = "blue";
            } else {
                color = "black";
            }

            if (el.estatus_cit === "4") {
                color = "green";
            }

            if (el.estatus_cit === "5") {
                color = "coral";
            }

            let cita = {
                color,
                allDay: 0,
                id: el.cita_id,
                start: `${el.fecha_cita}T${el.hora_entrada}`,
                end: `${el.fecha_cita}T${el.hora_salida}`,
                extendedProps: el,
                title: `${citaInfo.nombre_paciente} ${citaInfo.apellido_paciente} - ${citaInfo.nombre_especialidad}`
            };
            allCitas.push(cita);
        }));

		console.log(cachedCitas);
        return allCitas;

    } catch (error) {
        console.log(error);
    }
}