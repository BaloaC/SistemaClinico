import addModule from "../global/addModule.js";
import { select2OnClick, emptySelect2 } from "../global/dinamicSelect2.js";
import { calendar } from "./calendarioCitas.js";


const especialidadSelect = document.getElementById("s-especialidad");

// select2OnClick({
//     selectSelector: "#s-paciente",
//     selectValue: "paciente_id",
//     selectNames: ["cedula", "nombres-apellidos"],
//     module: "pacientes/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione un paciente"
// });


// // TODO: Colocar en la vista los horarios disponible de este medico
// select2OnClick({
//     selectSelector: "#s-medico",
//     selectValue: "medico_id",
//     selectNames: ["cedula", "nombres-apellidos"],
//     module: "medicos/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione un médico"
// });

// emptySelect2({
//     selectSelector: especialidadSelect,
//     placeholder: "Debe seleccionar un médico",
//     parentModal: "#modalReg"
// })

// select2OnClick({
//     selectSelector: "#s-seguro",
//     selectValue: "seguro_id",
//     selectNames: ["rif", "nombre"],
//     module: "seguros/consulta",
//     parentModal: "#modalReg",
//     placeholder: "Seleccione un seguro"
// });

// especialidadSelect.disabled = true;

// // TODO: Al seleccionar/cambiar el valor del medico, cargar unicamente sus especialidades, crear el input vacio afuera
// $("#s-medico").on("change", async function (e) {

//     const especialidades = await getAll("especialidades/consulta");

//     $(especialidadSelect).empty().select2();
//     dinamicSelect2({
//         obj: especialidades,
//         selectSelector: especialidadSelect,
//         selectValue: "especialidad_id",
//         selectNames: ["nombre"],
//         parentModal: "#modalReg",
//         placeholder: "Seleccione una especialidad"
//     });

//     especialidadSelect.disabled = false;
// })

// dinamicSelect2({
//     obj: [{
//         id: 1,
//         text: "Normal"
//     },
//     {
//         id: 2,
//         text: "Asegurada"
//     }],
//     selectNames: ["text"],
//     selectValue: "id",
//     selectSelector: "#s-tipo_cita",
//     placeholder: "Seleccione el tipo de cita",
//     parentModal: "#modalReg",
//     staticSelect: true
// });

async function addCita() {

    const $form = document.getElementById("info-cita"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        data.fecha_cita = data.fecha_cita.replace("T", " ");

        await addModule("citas", "info-cita", data, "Cita agendada exitosamente!");

        calendar.refetchEvents();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addCita = addCita;