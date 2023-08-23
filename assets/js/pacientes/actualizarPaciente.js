import addModule from "../global/addModule.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import deleteSecondValue from "../global/deleteSecondValue.js";
import dinamicSelect2, { select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";
import getById from "../global/getById.js";
import updateModule from "../global/updateModule.js";
import actualizarTipoPaciente from "./actualizarTipoPaciente.js";
import getTitulares from "./getTitulares.js";
import mostrarPacienteBeneficiado from "./mostrarPacienteBeneficiado.js";
import mostrarPacienteSeguro from "./mostrarPacienteSeguro.js";

const titulares = await getTitulares();
dinamicSelect2({
    obj: titulares,
    selectSelector: `#s-titular_id-act`,
    selectValue: "paciente_id",
    selectNames: ["cedula", "nombre-apellidos"],
    parentModal: "#modalAct",
    placeholder: "Seleccione un titular"
});

select2OnClick({
    selectSelector: "#s-seguro-act",
    selectValue: "seguro_id",
    selectNames: ["rif", "nombre"],
    module: "seguros/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione un seguro",
    multiple: true
});

select2OnClick({
    selectSelector: "#s-empresa-act",
    selectValue: "empresa_id",
    selectNames: ["rif", "nombre"],
    module: "empresas/consulta",
    parentModal: "#modalAct",
    placeholder: "Seleccione una empresa"
});


async function updatePaciente(id) {

    const $form = document.getElementById("act-paciente");

    try {
        const json = await getById("pacientes", id);

        // Obtener código telefónico
        let $telCod = json.telefono.slice(0, 4),
            $tel = json.telefono.split($telCod);

        for (const option of $form.cod_tel.options) {
            if (option.value === $telCod) {
                option.defaultSelected = true;
            }
        }

        for (const option of $form.tipo_paciente.options) {
            if (option.value === json.tipo_paciente) {
                option.defaultSelected = true;
            }
        }

        if (json.seguro) {
            mostrarPacienteSeguro(json.seguro);
        }

        if (json.tipo_paciente == "4") {
            const titulares = await getById("titulares", json.paciente_id) ?? [];
            mostrarPacienteBeneficiado(titulares);
        }

        //Establecer el option con los datos del usuario
        $form.nombre.value = json.nombre || json.nombre_paciente;
        $form.nombre.dataset.secondValue = json.nombre || json.nombre_paciente;
        $form.apellidos.value = json.apellidos;
        $form.apellidos.dataset.secondValue = json.apellidos;
        $form.cedula.value = json.cedula;
        $form.cedula.dataset.secondValue = json.cedula;
        $form.fecha_nacimiento.value = json.fecha_nacimiento;
        $form.fecha_nacimiento.dataset.secondValue = json.fecha_nacimiento;
        $form.direccion.value = json.direccion;
        $form.direccion.dataset.secondValue = json.direccion;
        $form.telefono.value = $tel[1];
        $form.telefono.dataset.secondValue = $tel[1];
        $form.cod_tel.dataset.secondValue = $telCod;
        $form.tipo_paciente.dataset.secondValue = json.tipo_paciente;

        actualizarTipoPaciente(json.tipo_paciente);

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = id;
        $inputId.name = "paciente_id";
        $form.appendChild($inputId);

        const $inputEdad = document.createElement("input");
        $inputEdad.type = "hidden";
        $inputEdad.value = json.edad;
        $inputEdad.dataset.secondValue = json.edad;
        $inputEdad.name = "edad";
        $form.appendChild($inputEdad);

    } catch (error) {

        console.log(error);
    }
}

window.updatePaciente = updatePaciente;

async function confirmUpdate() {
    const $form = document.getElementById("act-paciente"),
        $alert = document.getElementById("actAlert");
    const modalActContent = document.getElementById("modalActContent");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "Los nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.apellidos))) throw { message: "Los apellidos ingresado no es válido" };
        if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        // if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

        let $tel = data.cod_tel + data.telefono;

        const parseData = deleteSecondValue("#act-paciente input, #act-paciente select", data);

        // ** Si no existe tel o cod_tel en la data, añadirle el tel completo
        if ('telefono' in parseData || 'cod_tel' in parseData) { parseData.telefono = $tel }
        if ('fecha_nacimiento' in parseData) {
            let edad = data.fecha_nacimiento.split("-");
            parseData.edad = getAge(edad[0], edad[1], edad[2]);
        }

        // ** Enviar el seguro en caso de que se vaya a añadir uno en la actualizaron
        if ('seguro[]' in parseData && 'empresa_id' in parseData) {
            parseData.seguro = [{
                cobertura_general: parseData.cobertura_general,
                saldo_disponible: parseData.saldo_disponible,
                paciente_id: parseData.paciente_id,
                seguro_id: parseData["seguro[]"],
                empresa_id: parseData.empresa_id,
                fecha_contra: parseData.fecha_contra
            }]
        }

        if ('titular_id' in parseData && 'tipo_familiar' in parseData && 'tipo_relacion' in parseData && "paciente_beneficiado_id" in parseData) {

            parseData.titular = [{
                paciente_id: parseData.titular_id,
                tipo_relacion: parseData.tipo_relacion,
                tipo_familiar: parseData.tipo_familiar
            }]

            await addModule(`titular/${parseData.paciente_beneficiado_id}`, "act-poaciente", parseData.titular, "");

            delete parseData.titular;
        }

        await updateModule(parseData, "paciente_id", "pacientes", "act-paciente", "Paciente actualizado correctamente!");

        // Subir el scroll hasta inicio para visualizar mejor el mensaje de exito
        modalActContent.scrollTo({
            top: 0,
            bottom: modalActContent.scrollHeight,
            behavior: 'smooth'
        });

        // Eliminar que el input sea valido
        Array.from(document.getElementById("act-paciente").elements).forEach(element => {
            element.classList.remove('valid');
        })

        $('#s-cita').val([]).trigger('change');
        toggleAddSeguro("hide");
        toggleAddTitular("hide");
        deleteElementByClass("newInput");
        $('#pacientes').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        let message = error.message || error.result.message;
        $alert.textContent = message;

        // Subir el scroll hasta inicio para visualizar mejor el mensaje de error
        modalActContent.scrollTo({
            top: 0,
            bottom: modalActContent.scrollHeight,
            behavior: 'smooth'
        });

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }
}

window.confirmUpdate = confirmUpdate;