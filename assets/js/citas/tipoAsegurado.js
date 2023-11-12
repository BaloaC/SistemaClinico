import { emptySelect2, selectText } from "../global/dinamicSelect2.js";
import getById from "../global/getById.js";


export default async function tipoAsegurado(paciente_id) {

    console.log("a");

    const seguroSelect = document.getElementById("s-seguro");
    document.querySelector("label[for='seguro'").classList.remove("d-none");

    if (seguroSelect.dataset.create == 0) {
        emptySelect2({
            selectSelector: seguroSelect,
            placeholder: "Seleccione un seguro",
            parentModal: "#modalReg",
            disable: false,
        });
    }

    $(seguroSelect).on("select2:open", async function (e) {
        if (document.querySelector("#s-seguro").dataset.active == 0) {

            const infoPaciente = await getById("pacientes", paciente_id);

            if ('result' in infoPaciente && infoPaciente.result.code === false) return;

            // Vaciar opciones del elemento select
            $(seguroSelect).empty();

            infoPaciente.seguro.forEach((el) => {

                if ($(seguroSelect).find(`option[value="${el.seguro_id}"]`).length) {
                    $(seguroSelect).val(el.seguro_id);
                } else {
                    let newOption = new Option(selectText(["nombre_seguro", "nombre_empresa"], el), el.seguro_id, false, false);
                    $(seguroSelect).append(newOption);
                }
            });

            // Construir uno nuevo con la información que necesitas
            emptySelect2({
                selectSelector: seguroSelect,
                placeholder: "Seleccione un seguro",
                parentModal: "#modalReg",
                disable: false,
            });

            $(seguroSelect).val(0).trigger("change.select2");
            $(seguroSelect).select2("close");
            document.querySelector("#s-seguro").dataset.active = 1;
        }

        $(seguroSelect).on("change", function () {
            if ($(seguroSelect).val() != 0) {
                $(seguroSelect).removeClass("is-invalid");
                $(seguroSelect).addClass("is-valid");
            } else {
                $(seguroSelect).removeClass("is-valid");
                $(seguroSelect).addClass("is-invalid");
            }
        });

        $(seguroSelect).select2("open");
    });

    if ("#modalReg" !== null) {
        document.querySelector("#modalReg").addEventListener("hidden.bs.modal", (e) => {
            document.querySelector("#s-seguro").dataset.active = 0;
        });
    }
    // $('#s-seguro').next('.select2-container').fadeOut('slow');
    // $('#s-seguro').next('.select2-container').fadeIn('slow');
}


window.tipoAsegurado = tipoAsegurado;
