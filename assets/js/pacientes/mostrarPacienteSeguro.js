import deleteElementByClass from "../global/deleteElementByClass.js";
import dinamicSelect2, { emptySelect2 } from "../global/dinamicSelect2.js";
import toggleAddSeguro from "./toggleAddSeguro.js";

export default function mostrarPacienteSeguro(seguros){
    
    if(seguros.length > 0){

        toggleAddSeguro("hide");
        $("#btn-add-seguro").fadeOut("slow");
        $("#pacienteSinSeguroMessage").fadeOut("slow");

        let template = "";

        seguros.forEach(el => {
            template += `
                <div class="row align-items-center newInput">
                    <hr>
                     <div class="col-12 col-md-5">
                        <label for="tipo_relacion">Nombre Empresa</label>
                        <select id="act-s-empresa_id" name="empresa_id-act" data-second-value="${el.empresa_id}" class="form-control mb-3">
                            <option value="${el.empresa_id}">${el.nombre_empresa}</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="titular">Fecha contratación</label>
                        <input type="date" class="form-control mb-3" name="fecha_contra-act" data-second-value="${el.fecha_contra}" data-validation="true" date-type="date" id="act-fecha_contra" value="${el.fecha_contra}">
                    </div>
                     <div class="col-12 col-md-5">
                        <label for="titular">Nombre Seguro</label>
                        <select id="act-s-seguro_id" name="seguro_id-act" data-second-value="${el.seguro_id}" class="form-control mb-3">
                            <option value="${el.seguro_id}">${el.nombre_seguro}</option>
                        </select>
                    </div>
                    <input type="hidden" name="paciente_seguro_id-act" data-second-value="${el.paciente_seguro_id}" value="${el.paciente_seguro_id}">
                </div>
                
            `;
        })

        deleteElementByClass("newInput");
        document.getElementById("submenu-seguro-title").insertAdjacentHTML("afterend", template);

        const seguroSelect = document.getElementById("act-s-seguro_id");
        const empresaSelect = document.getElementById("act-s-empresa_id");

        emptySelect2({
            selectSelector: seguroSelect,
            placeholder: "Debe seleccionar una empresa",
            parentModal: "#modalAct",
        })

        emptySelect2({
            selectSelector: empresaSelect,
            placeholder: "Seleccione una empresa",
            parentModal: "#modalAct",
        })

        dinamicSelect2({
            // obj: titularesList,
            selectSelector: empresaSelect,
            selectValue: "empresa_id",
            selectNames: ["rif", "nombre_empresa"],
            parentModal: "#modalAct",
            placeholder: "Seleccione una empresa",
            ajax: true,
            ajaxUrl: "empresas/consulta",
            queryPage: false,
            processResultsAjax: function (data, params) {

                const data1 = [];

                if (typeof data === "object" && data?.data !== 0) {

                    data?.data?.forEach(object => {

                        const { empresa_id: valorPropiedad1, nombre, rif} = object;

                        data1.push({ id: valorPropiedad1, text: `${rif} - ${nombre}`});
                    });
                }

                // Transforms the top-level key of the response object from 'data' to 'results'
                return {
                    results: data1 ?? []
                };
            }
        });

        $(empresaSelect).on("change", async function (e) {
            
            $(seguroSelect).empty().select2();

            dinamicSelect2({
                // obj: segurosList,
                selectSelector: seguroSelect,
                selectValue: "seguro_id",
                selectNames: ["rif", "nombre"],
                parentModal: "#modalAct",
                placeholder: "Debe seleccionar una empresa primero",ajax: true,
                ajaxUrl: `seguros/empresas/${this.value}`,
                queryPage: false,
                processResultsAjax: function (data, params) {
    
                    const data1 = [];
    
                    if (typeof data === "object" && data?.data !== 0) {
    
                        data?.data?.forEach(object => {
    
                            const { seguro_id: valorPropiedad1, nombre, rif} = object;
    
                            data1.push({ id: valorPropiedad1, text: `${rif} - ${nombre}`});
                        });
                    }
    
                    // Transforms the top-level key of the response object from 'data' to 'results'
                    return {
                        results: data1 ?? []
                    };
                }
            });
        });
        
    } else{
        deleteElementByClass("newInput");
        $("#btn-add-seguro").fadeIn("slow");
        $("#pacienteSinSeguroMessage").fadeIn("slow");
        document.getElementById("s-empresa-act").disabled = true;
        document.getElementById("s-seguro-act").disabled = true;
    }
    
}