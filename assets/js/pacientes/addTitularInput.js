import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";

async function getTitulares() {
    try {
        const pacientes = await getAll("pacientes/consulta"),
            titulares = [];
        pacientes.filter(paciente => (paciente.tipo_paciente == 2 || paciente.tipo_paciente == 3) ? titulares.push(paciente) : null);

        return titulares;
    } catch (error) {
        console.log(error);
    }
};

let clicks = 0;
async function addTitularInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <hr>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteTitularInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
            <div class="col-12 col-md-5">
                <label for="titular">Titular</label>
                <select name="titular_id" id="s-titular_id${clicks}" class="form-control mb-3 titular" data-active="0">
                    <option value="">Seleccione un titular</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Tipo de relación</label>
                <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3 relacion">
                    <option value="" disabled>Seleccione el tipo de relación</option>
                    <option value="1">Seguro</option>
                    <option value="2">Padre/Madre</option>
                    <option value="3">Representante</option>
                </select>
            </div>
        </div>
    `;
    document.getElementById("addTitular").insertAdjacentHTML("beforebegin", template);
    const titulares = await getTitulares();
    dinamicSelect2({
        obj: titulares,
        selectSelector: `#s-titular_id${clicks}`,
        selectValue: "paciente_id",
        selectNames: ["cedula", "nombre-apellidos"],
        parentModal: "#modalReg",
        placeholder: "Seleccione un titular"
    });
}

//TODO: cuando cerremos el modal, se eliminen los inputs restastes
//TODO: que al cerrar el modal o registro exitoso, se recarguen los select2

const titulares = await getTitulares();

$("#s-titular_id").empty().select2();
dinamicSelect2({
    obj: titulares,
    selectSelector: "#s-titular_id",
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    parentModal: "#modalReg",
    placeholder: "Seleccione un titular"
});

window.addTitularInput = addTitularInput;