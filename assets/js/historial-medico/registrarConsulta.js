import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getById from "../global/getById.js";
import dinamicSelect2, { emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

const id = location.pathname.split("/")[4];

select2OnClick({
    selectSelector: "#s-paciente",
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    module: "pacientes/consulta",
    parentModal: "#modalRegConsulta",
    placeholder: "Seleccione un paciente"
});

const citasSelect = document.getElementById("s-cita");

emptySelect2({
    selectSelector: citasSelect,
    placeholder: "Debe seleccionar un paciente",
    parentModal: "#modalRegConsulta"
})

citasSelect.disabled = true;

$("#s-paciente").on("change", async function (e) {

    let paciente_id = this.value;

    if (!paciente_id) return;

    let infoCitas = await getById("citas/paciente", paciente_id);

    $(citasSelect).empty().select2();

    if ('result' in infoCitas && infoCitas.result.code === false) infoCitas = [];

    dinamicSelect2({
        obj: infoCitas,
        selectSelector: citasSelect ?? [],
        selectValue: "cita_id",
        selectNames: ["cita_id", "motivo_cita"],
        parentModal: "#modalRegConsulta",
        placeholder: "Seleccione un paciente"
    });

    citasSelect.disabled = false;
})


select2OnClick({
    selectSelector: "#s-examen",
    selectValue: "examen_id",
    selectNames: ["nombre"],
    module: "examenes/consulta",
    parentModal: "#modalRegConsulta",
    placeholder: "Seleccione los exámenes",
    multiple: true
});

// select2OnClick({
//     selectSelector: "#s-insumo",
//     selectValue: "insumo_id",
//     selectNames: ["nombre"],
//     module: "insumos/consulta",
//     parentModal: "#modalRegConsulta",
//     placeholder: "Seleccione el insumo"
// });

// select2OnClick({
//     selectSelector: "#s-medicamento",
//     selectValue: "medicamento_id",
//     selectNames: ["nombre_medicamento"],
//     module: "medicamento/consulta",
//     parentModal: "#modalRegConsulta",
//     placeholder: "Seleccione el medicamento"
// });


async function addConsulta() {

    const $form = document.getElementById("info-consulta"),
        $alert = document.querySelector(".alertConsulta");

    try {
        const formData = new FormData($form),
            data = {},
            examenes = [];

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        const infoCita = await getById("citas", data.cita_id);
        data.cedula_titular = infoCita[0].cedula_titular;
        data.especialidad_id = infoCita[0].especialidad_id;
        data.medico_id = infoCita[0].medico_id;

        let examen = formData.getAll("examenes[]");
        examen.forEach(e => {
            const examen_id = {
                examen_id: e,
            }
            examenes.push(examen_id);
        })

        if (examenes.length != 0) { data.examenes = examenes; }

        const $insumos = document.querySelectorAll(".insumo-id"),
            $insumosCant = document.querySelectorAll(".insumo-cant"),
            insumos = [];

        $insumos.forEach((value, key) => {
            const insumo = {
                insumo_id: value.value,
                cantidad: $insumosCant[key].value
            }
            insumos.push(insumo);
        })
        
        if (insumos.length != 0 && insumos[0].insumo_id != "" && insumos[0].cantidad != "") { data.insumos = insumos; }

        const medicamentos = document.querySelectorAll(".medicamento-id"),
            medicamentoUso = document.querySelectorAll(".uso-medicamento"),
            recipes = [];

        medicamentos.forEach((value, key) => {
            const medicamento = {
                medicamento_id: value.value,
                uso: medicamentoUso[key].value
            }
            recipes.push(medicamento);
        })

        if (recipes.length != 0 && recipes[0].medicamento_id != "" && recipes[0].uso != "") { data.recipes = recipes; }

        const indicacionesList = document.querySelectorAll(".indicaciones"),
            indicaciones = [];

            indicacionesList.forEach((value, key) => {
            const indicacion = {
                descripcion: value.value
            }
            indicaciones.push(indicacion);
        })

        if (indicaciones.length != 0 && indicaciones[0].descripcion != "") { data.indicaciones = indicaciones; }





        // TODO: Validar los inputs del paciente

        // if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.altura))) throw { message: "La altura no es válida" };
        // if (!(/^[0-9]*\.?[0-9]+$/.test(data.peso))) throw { message: "La cédula no es válida" };


        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        const registroExitoso = await addModule("consultas", "info-consulta", data, "Consulta registrada correctamente!","#modalRegConsulta", ".alertConsulta");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        Array.from(document.getElementById("info-consulta").elements).forEach(element => {
            element.classList.remove('valid');
        })
        $form.reset();
        $('#s-paciente').val([]).trigger('change');
        $('#s-examen').val([]).trigger('change');
        $('#s-insumo').val([]).trigger('change');
        $('#s-medicamento').val([]).trigger('change');
        $('#s-cita').val([]).trigger('change');
        $('#s-cita').empty().trigger('change');
        document.getElementById("s-cita").disabled = true;
        deleteElementByClass("newInput");
        setTimeout(() => {
            $("#modalRegConsulta").modal("hide");
        }, 500);
        mostrarHistorialMedico(id);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addConsulta = addConsulta;
document.getElementById("info-consulta").addEventListener('submit', (event) => {
    event.preventDefault();
    addConsulta();
})

