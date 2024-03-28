import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

const id = location.pathname.split("/")[4];
const data = await getById("factura/consultaSeguro",id);

console.log(data);
document.getElementById("nombrePaciente").textContent = `${data?.beneficiado?.nombre ?? data?.paciente_beneficiado?.nombre} ${data?.beneficiado?.apellidos ?? data?.paciente_beneficiado?.apellidos}`;
document.getElementById("nombrePaciente2").textContent = `${data?.beneficiado?.nombre ?? data?.paciente_beneficiado?.nombre} ${data?.beneficiado?.apellidos ?? data?.paciente_beneficiado?.apellidos}`;
document.getElementById("cedulaPaciente").textContent = `${data?.beneficiado?.cedula ?? data?.paciente_beneficiado?.cedula}`;
document.getElementById("cedulaPaciente2").textContent = `${data?.beneficiado?.cedula ?? data?.paciente_beneficiado?.cedula}`;
document.getElementById("fechaNacimiento").textContent = `${formatToRealDate(data?.beneficiado?.fecha_nacimiento) ?? formatToRealDate(data?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("fechaNacimiento2").textContent = `${formatToRealDate(data?.beneficiado?.fecha_nacimiento) ?? formatToRealDate(data?.paciente_beneficiado?.fecha_nacimiento)}`;
document.getElementById("direccion").textContent = `${data?.beneficiado?.direccion ?? data?.paciente_beneficiado?.direccion}`;
document.getElementById("telefono").textContent = `${data?.beneficiado?.telefono ?? data?.paciente_beneficiado?.direccion}`;
document.getElementById("seguro").textContent = `${data?.seguro?.nombre ?? "No ubicado"}`;
document.getElementById("especialidad").textContent = `${data?.medico[0]?.nombre_especialidad ?? data?.especialidad?.nombre}`;
document.getElementById("especialidad2").textContent = `${data?.medico[0]?.nombre_especialidad ?? data?.especialidad?.nombre}`;
document.getElementById("especialidad2").textContent = `${data?.medico[0]?.nombre_especialidad ?? data?.especialidad?.nombre}`;
document.getElementById("nombreTitular").textContent = `${data?.titular?.nombre ?? data?.paciente_titular?.nombre} ${data?.titular?.apellidos ?? data?.paciente_titular?.apellidos}`;
document.getElementById("cedulaTitular").textContent = `${data?.titular?.cedula ?? data?.paciente_titular?.cedula}`;
document.getElementById("observaciones").textContent = `${data?.consulta?.observaciones ?? "Sin observaciones"}`;

window.print();