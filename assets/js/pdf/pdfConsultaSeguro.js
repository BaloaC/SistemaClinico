import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("factura/consultaSeguro/",id);
const dataSeguro = await getById("seguros/",data.seguro_id);
console.log("🍓 ~ file: pdfConsultaSeguro.js:7 ~ dataSeguro:", dataSeguro)

console.log("🍓 ~ file: pdfConsultaSeguro.js:6 ~ data:", data)



// TODO: Consultar el paciente y colocar sus datos también aquí

document.getElementById("clave").textContent = `${data.cita.clave ?? "No encontrada"}`;
document.getElementById("fechaIngreso").textContent = `${data.cita.fecha_cita}`;
document.getElementById("nombrePaciente").textContent = `${data?.paciente_beneficiado?.nombre} ${data?.paciente_beneficiado?.apellidos}`;
document.getElementById("nombrePaciente2").textContent = `${data?.paciente_beneficiado?.nombre} ${data?.paciente_beneficiado?.apellidos}`;
document.getElementById("cedulaPaciente").textContent = `${data?.paciente_beneficiado?.cedula}`;
document.getElementById("cedulaPaciente2").textContent = `${data?.paciente_beneficiado?.cedula}`;
document.getElementById("fechaNacimiento").textContent = `${formatToRealDate(data?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("fechaNacimiento2").textContent = `${formatToRealDate(data?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("direccion").textContent = `${data?.paciente_beneficiado?.direccion}`;
document.getElementById("telefono").textContent = `${data?.paciente_beneficiado?.telefono}`;
document.getElementById("seguro").textContent = `${dataSeguro.nombre ?? "No ubicado"}`;
document.getElementById("especialidad").textContent = `${data?.especialidad?.nombre}`;
document.getElementById("especialidad2").textContent = `${data?.especialidad?.nombre}`;
document.getElementById("nombreMedico").textContent = `${data?.medico?.nombre} ${data?.medico?.apellidos}`;
document.getElementById("nombreTitular").textContent = `${data?.paciente_titular?.nombre} ${data?.paciente_titular?.apellidos}`;
document.getElementById("cedulaTitular").textContent = `${data?.paciente_titular?.cedula}`;
document.getElementById("observaciones").textContent = `${data?.consulta?.observaciones ?? "Sin observaciones"}`;

window.print();