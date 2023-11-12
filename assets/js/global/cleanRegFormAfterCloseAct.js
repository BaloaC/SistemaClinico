import cleanValdiationByClass from "./cleanValidationsByClass.js";

document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("modalAct") ?? undefined;

    if (modal !== undefined) {
        modal.addEventListener("hidden.bs.modal", () => {
            //Limpiar las validaciones del registro luego de abrir el modal de actualizar
            cleanValdiationByClass(".form-reg");
        });
    }
})

