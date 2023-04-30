import getAll from "../global/getAll.js";
import concatItems from "../global/concatItems.js";


const id = location.pathname.split("/")[4];
const infoConsultas = await getAll("consultas/consulta");
const consultasPacientes = infoConsultas.filter(consulta => consulta.paciente_id == id);
const template = document.getElementById("consulta-template").content;
const fragment = document.createDocumentFragment();

document.getElementById("nombres").textContent = consultasPacientes[0].nombre_paciente;
document.getElementById("apellidos").textContent = consultasPacientes[0].apellido_paciente;
document.getElementById("cedula").textContent = consultasPacientes[0].cedula_paciente;

consultasPacientes.forEach(e => {
    template.getElementById("consulta_id").textContent = e.consulta_id;
    template.getElementById("fecha").textContent = e.fecha_consulta;
    template.getElementById("nombre_medico").textContent = `${e.nombre_medico} ${e.apellido_medico}`;
    template.getElementById("especialidad").textContent = e.nombre_especialidad;
    template.getElementById("examen").textContent = concatItems(e.examenes, "nombre", "No se realizó ningún exámen");
    template.getElementById("insumo").textContent = concatItems(e.insumos, "nombre", "No se utilizó ningún insumos");
    template.getElementById("observaciones").textContent = e.observaciones ?? "Sin observaciones";

    let clone = document.importNode(template, true);
    fragment.appendChild(clone);
})

document.querySelector("body").appendChild(fragment);

window.print();
