import getById from "../global/getById.js";

export default async function parseCitas(citas) {
	try {
		const allCitas = [];

		await Promise.all(citas.map(async (el) => {

			const citaInfo = await getById("citas", el.cita_id);
			let color;

			if(el.tipo_cita === "1"){
				color = "blue";
			} else {
				color = "black";
			}

			if(el.estatus_cit === "4"){
				color = "green"
			}

			if(el.estatus_cit === "5"){
				color = "coral"
			}

			let cita = {
				color,
				allDay: 0,
				id: el.cita_id,
				start: `${el.fecha_cita}T${el.hora_entrada}`,
				end: `${el.fecha_cita}T${el.hora_salida}`,
				extendedProps: el,
				title: `${citaInfo.nombre_paciente} ${citaInfo.apellido_paciente} - ${citaInfo.nombre_especialidad}`
				// title: `test1`
			};
			allCitas.push(cita);
		}));

		return allCitas;

	} catch (error) {

		console.log(error);
	}
}