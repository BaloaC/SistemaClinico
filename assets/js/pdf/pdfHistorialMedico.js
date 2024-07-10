import getAll from "../global/getAll.js";
import concatItems from "../global/concatItems.js";
import formatToRealDate from "../global/formatToRealDate.js";


const id = location.pathname.split("/")[4];
const infoConsultas = await getAll(`consultas/paciente/${id}`);
const consultasPacientes = infoConsultas.consultas;
const template = document.getElementById("consulta-template").content;
const fragment = document.createDocumentFragment();

document.getElementById("nombres").textContent = consultasPacientes[0].nombre_paciente;
document.getElementById("apellidos").textContent = consultasPacientes[0].apellido_paciente;
document.getElementById("cedula").textContent = consultasPacientes[0].cedula_paciente;

consultasPacientes.forEach(e => {

    console.log("🍓 ~ file: pdfHistorialMedico.js:31 ~ e:", e)

    template.getElementById("consulta_id").textContent = e.consulta_id;
    template.getElementById("fecha").textContent = formatToRealDate(e.fecha_consulta);
    template.getElementById("nombre_medico").textContent = `${e.nombre_medico ?? ""} ${e.apellidos_medico ?? "Consulta por emergencia"}`;
    template.getElementById("especialidad").textContent = e.nombre_especialidad ?? "Consulta por emergencia";
    template.getElementById("examen").textContent = concatItems(e.examenes, "nombre", "No se realizó ningún exámen");
    template.getElementById("insumo").textContent = concatItems(e.insumos, "nombre", "No se utilizó ningún insumos");
    template.getElementById("observaciones").textContent = e.observaciones ?? "Sin observaciones";

    let clone = document.importNode(template, true);
    fragment.appendChild(clone);
})


document.querySelector("body").appendChild(fragment);

window.print();
