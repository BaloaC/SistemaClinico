import { select2OnClick } from "../global/dinamicSelect2";

// Update
select2OnClick({
    selectSelector: "#s-especialidad-update",
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    module: "especialidades/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione una especialidad",
});
