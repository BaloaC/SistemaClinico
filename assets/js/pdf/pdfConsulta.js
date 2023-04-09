import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("consultas",id);

console.log(data);
 document.getElementById("consulta_id").textContent = data[0].consulta_id;
 document.getElementById("paciente").textContent = `${data[0].nombre_paciente} ${data[0].apellido_paciente}`;
 document.getElementById("cedula_paciente").textContent = data[0].cedula_paciente;
 document.getElementById("fecha").textContent = data[0].fecha_consulta;
 document.getElementById("medico").textContent = `${data[0].nombre_medico} ${data[0].apellido_medico}`;
 document.getElementById("especialidad").textContent = data[0].nombre_especialidad;
 document.getElementById("observaciones").textContent = data[0].observaciones ?? "Sin observaciones";

 window.print();