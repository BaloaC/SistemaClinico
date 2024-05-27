import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("consultas/",id);

// TODO: Consultar el paciente y colocar sus datos también aquí

document.getElementById("nombrePaciente").textContent = `${data[0].nombre_paciente ?? data[0]?.beneficiado?.nombre ?? data[0]?.paciente_beneficiado?.nombre} ${data[0].apellido_paciente ?? data[0]?.beneficiado?.apellidos ?? data[0]?.paciente_beneficiado?.apellidos}`;
document.getElementById("nombrePaciente2").textContent = `${data[0].nombre_paciente ?? data[0]?.beneficiado?.nombre ?? data[0]?.paciente_beneficiado?.nombre} ${data[0].apellido_paciente ?? data[0]?.beneficiado?.apellidos ?? data[0]?.paciente_beneficiado?.apellidos}`;
document.getElementById("cedulaPaciente").textContent = `${data[0].cedula_paciente ?? data[0]?.beneficiado?.cedula ?? data[0]?.paciente_beneficiado?.cedula}`;
document.getElementById("cedulaPaciente2").textContent = `${data[0].cedula_paciente ?? data[0]?.beneficiado?.cedula ?? data[0]?.paciente_beneficiado?.cedula}`;
document.getElementById("fechaNacimiento").textContent = `${formatToRealDate(data[0]?.beneficiado?.fecha_nacimiento) ?? formatToRealDate(data[0]?.beneficiado?.fecha_nacimiento) ?? formatToRealDate(data[0]?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("fechaNacimiento2").textContent = `${formatToRealDate(data[0]?.beneficiado?.fecha_nacimiento) ?? formatToRealDate(data[0]?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("direccion").textContent = `${data[0]?.beneficiado?.direccion ?? data[0]?.paciente_beneficiado?.direccion}`;
document.getElementById("telefono").textContent = `${data[0]?.beneficiado?.telefono ?? data[0]?.paciente_beneficiado?.direccion}`;
document.getElementById("seguro").textContent = `${data[0]?.seguro?.nombre ?? "No ubicado"}`;
document.getElementById("especialidad").textContent = `${data[0]?.medico[0]?.nombre_especialidad ?? data[0]?.especialidad?.nombre}`;
document.getElementById("especialidad2").textContent = `${data[0]?.medico[0]?.nombre_especialidad ?? data[0]?.especialidad?.nombre}`;
document.getElementById("nombreMedico").textContent = `${data[0]?.medico[0]?.nombre_medico ?? data[0]?.medico[0]?.nombre} ${data[0]?.medico[0]?.apellidos_medico ?? data[0]?.medico[0]?.apellidos}`;
document.getElementById("especialidad2").textContent = `${data[0]?.medico[0]?.nombre_especialidad ?? data[0]?.especialidad?.nombre}`;
document.getElementById("nombreTitular").textContent = `${data[0]?.titular?.nombre ?? data[0]?.paciente_titular?.nombre} ${data[0]?.titular?.apellidos ?? data[0]?.paciente_titular?.apellidos}`;
document.getElementById("cedulaTitular").textContent = `${data[0]?.titular?.cedula ?? data[0]?.paciente_titular?.cedula}`;
document.getElementById("observaciones").textContent = `${data[0]?.consulta?.observaciones ?? "Sin observaciones"}`;

window.print();