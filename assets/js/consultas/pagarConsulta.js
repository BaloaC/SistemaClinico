import { createOptionOrSelectInstead } from "../global/dinamicSelect2.js";

function pagarConsulta(tipo, paciente_id, consulta_id){ 
    createOptionOrSelectInstead({
        obj: {},
        selectSelector: "#s-especialidad-update",
        selectNames: ["nombre_especialidad"],
        selectValue: "especialidad_id"
    });
}