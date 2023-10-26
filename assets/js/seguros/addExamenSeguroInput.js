import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
async function addExamenSeguroInput() {

    clicks += 1;
    let template = `
    <div class="row align-items-center newInput">
        <hr class="mt-4">
            <div class="col-10">
                <div class="col-11">
                    <label for="examen">Exámen</label>
                    <select name="examen_id" id="s-examen_id${clicks}" class="form-control mb-3 examen" data-active="0" required>
                        <option value="" selected>Seleccione un exámen</option>
                    </select>
                </div>
                <div class="col-11">
                    <label for="costo">Costo</label>
                    <input type="number" name="costo" class="form-control costos" data-validate="true" data-type="number" data-max-length="5" required>
                </div>
                <div class="col-2">
                <button type="button" class="btn" onclick="deleteExamenSeguroInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addExamen").insertAdjacentHTML("beforebegin", template);

    // TODO: Filtrar por solos los examenes hechos en la clinica

    select2OnClick({
        selectSelector: `#s-examen_id${clicks}`,
        selectValue: "examen_id",
        selectNames: ["nombre"],
        module: "examenes/consulta",
        parentModal: "#modalReg",
        placeholder: "Seleccione un exámen"
    });
}

select2OnClick({
    selectSelector: `#s-examen_id`,
    selectValue: "examen_id",
    selectNames: ["nombre"],
    module: "examenes/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un exámen"
});

window.addExamenSeguroInput = addExamenSeguroInput;