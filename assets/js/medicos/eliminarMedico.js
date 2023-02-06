import { mostrarMedicos } from "./mostrarMedicos.js";
import deleteModule from "../global/deleteModule.js";


async function deleteMedico(id) {
    await deleteModule("medicos", id, "Médico eliminado exitosamente!");
    mostrarMedicos();
}

window.deleteMedico = deleteMedico;