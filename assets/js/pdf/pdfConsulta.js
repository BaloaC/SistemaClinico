import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("consultas",id);

console.log(data);
 document.getElementById("consulta_id").textContent = data.consulta_id;
 document.getElementById("paciente").textContent = data.nombre_paciente !== undefined ? `${data.nombre_paciente} ${data.apellido_paciente}` : `${data.beneficiado.nombre} ${data.beneficiado.apellidos}`;
 document.getElementById("cedula_paciente").textContent = data.cedula_paciente ?? data?.beneficiado?.cedula;
 document.getElementById("fecha").textContent = data.fecha_consulta;
 document.getElementById("medico").textContent =  data.nombre_medico !== undefined ? `${data.nombre_medico} ${data.apellidos_medico}` : "Consulta por emergencia";
 document.getElementById("especialidad").textContent = data.nombre_especialidad ?? "Consulta por emergencia";
 document.getElementById("observaciones").textContent = data.observaciones ?? "Sin observaciones";

window.print();