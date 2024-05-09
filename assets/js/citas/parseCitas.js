import getById from "../global/getById.js";

export default async function parseCitas(citas) {
	try {
		const allCitas = [];

		await Promise.all(citas.map(async (el) => {

			const citaInfo = await getById("citas", el.cita_id);

			let cita = {
				color: (el.tipo_cita === "1") ? "blue" : "black",
				allDay: 0,
				id: el.cita_id,
				start: `${el.fecha_cita}T${el.hora_entrada}`,
				end: `${el.fecha_cita}T${el.hora_salida}`,
				extendedProps: el,
				title: `${citaInfo.cedula_paciente} - ${citaInfo.nombre_paciente} ${citaInfo.apellido_paciente} - ${citaInfo.nombre_especialidad} - ${citaInfo.motivo_cita}`
			};
			allCitas.push(cita);
		}));

		return allCitas;

	} catch (error) {

		console.log(error);
	}
}