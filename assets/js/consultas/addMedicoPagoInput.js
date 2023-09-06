import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addMedicoPagoInput(parentModal = "#modalReg") {

    clicks += 1;
    let template = `

    <div class="row align-items-center newInput">
        <div class="col-3 col-md-1">
            <button type="button" class="btn" onclick="deleteInput(this,'.medico-pago-id')"><i class="fas fa-times m-0"></i></button>
        </div>
        <div class="col-12 col-md-5">
            <label for="medico">Médico</label>
            <select id="s-medico-pago${clicks}" class="form-control medico-pago-id" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto" class="p-0">Monto</label>
            <input type="number" step="any" class="form-control monto-pago" required>
        </div>
    </div>
    `;
    document.getElementById("addMedicoPago").insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-medico-pago${clicks}`,
        selectValue: "medico_id",
        selectNames: ["cedula", "nombre-apellidos"],
        module: "medicos/consulta",
        parentModal: parentModal,
        placeholder: "Seleccione un médico"
    });
}

window.addMedicoPagoInput = addMedicoPagoInput;