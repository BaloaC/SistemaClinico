import { emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";
import tipoAsegurado from "./tipoAsegurado.js";


export default async function tipoTitular(inputRadio) {
    if (inputRadio.value === "beneficiado") {
        const titularSelect = document.getElementById("s-titular");
        document.querySelector("label[for='titular_id'").classList.remove("d-none");

        if (titularSelect.dataset.create == 0) {
            emptySelect2({
                selectSelector: titularSelect,
                placeholder: "Seleccione un paciente",
                parentModal: "#modalReg",
                disable: false,
            });
        }

        $(titularSelect).on("select2:open", async function (e) {
            if (document.querySelector("#s-titular").dataset.active == 0) {

                // Vaciar opciones del elemento select
                $(titularSelect).empty();

                let paciente_id = inputRadio.dataset.pacienteId;
                let tipo_paciente = inputRadio.dataset.tipoPaciente;
                let infoPaciente;

                if (tipo_paciente == 2) {
                    infoPaciente = await getById("titularesBeneficiado", paciente_id);
                } else {
                    infoPaciente = await getById("titulares", paciente_id);
                }

                if ('result' in infoPaciente && infoPaciente.result.code === false) return;

                infoPaciente.forEach((el) => {


                    if (el.tipo_paciente == 1) el.tipo_paciente = "Natural";
                    else if (el.tipo_paciente == 2) el.tipo_paciente = "Representante";
                    else if (el.tipo_paciente == 3) el.tipo_paciente = "Asegurado";
                    else if (el.tipo_paciente == 4) el.tipo_paciente = "Beneficiado";

                    if ($(titularSelect).find(`option[value="${el.paciente_id}"]`).length) {
                        $(titularSelect).val(el.paciente_id);
                    } else {
                        let newOption = new Option(selectText(["cedula", "nombre-apellidos", "tipo_paciente"], el), el.paciente_id, false, false);
                        $(titularSelect).append(newOption);
                    }
                });

                // Construir uno nuevo con la información que necesitas
                emptySelect2({
                    selectSelector: titularSelect,
                    placeholder: "Seleccione un paciente",
                    parentModal: "#modalReg",
                    disable: false,
                });

                $(titularSelect).val(0).trigger("change.select2");
                $(titularSelect).select2("close");
                document.querySelector("#s-titular").dataset.active = 1;
            }

            $(titularSelect).on("change", function () {
                if ($(titularSelect).val() != 0) {
                    $(titularSelect).removeClass("is-invalid");
                    $(titularSelect).addClass("is-valid");
                } else {
                    $(titularSelect).removeClass("is-valid");
                    $(titularSelect).addClass("is-invalid");
                }
            });

            $(titularSelect).select2("open");
        });

        if ("#modalReg" !== null) {
            document.querySelector("#modalReg").addEventListener("hidden.bs.modal", (e) => {
                document.querySelector("#s-titular").dataset.active = 0;
            });
        }
        // $('#s-titular').next('.select2-container').fadeOut('slow');
        // $('#s-titular').next('.select2-container').fadeIn('slow');
    } else {
        $('#s-titular').next('.select2-container').fadeOut('slow');
        document.querySelector("label[for='titular_id'").classList.add("d-none");
    }

    $("#s-titular").on("change", async function (e) {

        let paciente_id = this.value;
        const infoPaciente = await getById("pacientes", paciente_id);
        const inputTipoCita = document.getElementById("s-tipo_cita");

        // ** Si no es asegurado deshabilitarle el tipo de cita asegurada, en caso de que no, habilitarle el tipo de cita asegurada y crearle el select2
        if(infoPaciente.tipo_paciente != 3){
            inputTipoCita.querySelector("option[value='2']").disabled = true;
            inputTipoCita.querySelector("option[value='1']").selected = true;
        } else{
            inputTipoCita.querySelector("option[value='2']").disabled = false;
            document.querySelector("#s-seguro").dataset.active = 0;
            tipoAsegurado(infoPaciente.paciente_id);
        }
    })
}


window.tipoTitular = tipoTitular;
