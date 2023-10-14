import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("citas", id);


document.getElementById("cita_id").textContent = data.cita_id;
document.getElementById("paciente").textContent = `${data.nombre_paciente} ${data.apellido_paciente}`;
document.getElementById("cedula_paciente").textContent = data.cedula_paciente;
document.getElementById("cedula_titular").textContent = data.cedula_titular;
document.getElementById("tipo_cita").textContent = (data.tipo_cita == 1) ? "Natural" : "Asegurada";
document.getElementById("fecha_cita").textContent = data.fecha_cita.split(" ");
document.getElementById("medico").textContent = `${data.nombre_medico} ${data.apellido_medico}`;
document.getElementById("especialidad").textContent = data.nombre_especialidad;

window.print();