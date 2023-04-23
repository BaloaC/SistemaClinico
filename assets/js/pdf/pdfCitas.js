import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("citas", id);

document.getElementById("cita_id").textContent = data[0].cita_id;
document.getElementById("paciente").textContent = `${data[0].nombre_paciente} ${data[0].apellido_paciente}`;
document.getElementById("cedula_paciente").textContent = data[0].cedula_paciente;
document.getElementById("cedula_titular").textContent = data[0].cedula_titular;
document.getElementById("tipo_cita").textContent = (data[0].tipo_cita == 1) ? "Natural" : "Asegurada";
document.getElementById("fecha_cita").textContent = data[0].fecha_cita.split(" ")[0];
document.getElementById("medico").textContent = `${data[0].nombre_medico} ${data[0].apellido_medico}`;
document.getElementById("especialidad").textContent = data[0].nombre_especialidad;

window.print();