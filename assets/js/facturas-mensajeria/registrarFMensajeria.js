import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import dinamicSelect2, { emptyAllSelect2, emptySelect2, select2OnClick } from "../global/dinamicSelect2.js";
import getAge from "../global/getAge.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";


const path = location.pathname.split('/');

let modalOpened = false;

export const registerStatusFactura = {
    successfulFactura: false,
};
const modalRegister = document.getElementById("modalRegNormal") ?? undefined;

const handleModalOpen = async () => {


    // En caso de que se haya registrado correctamente una consulta por cita, volvemos actualizar el select de las citas
    if (registerStatusFactura.successfulFactura === true) {

        const infoCitas = await getAll("citas/consulta");
        let listCitas;

        if ('result' in infoCitas && infoCitas.result.code === false) listCitas = [];


        if (infoCitas.length > 0) {
            listCitas = infoCitas.filter(cita => cita.estatus_cit === "1");
        }

        emptyAllSelect2({
            selectSelector: "#s-seguro",
            placeholder: "Seleccione el seguro",
            parentModal: "#modalRegNormal"
        });

        dinamicSelect2({
            obj: listSeguros ?? [],
            selectSelector: "#s-seguro",
            selectValue: "seguro_id",
            selectNames: ["rif", "nombre"],
            parentModal: "#modalRegNormal",
            placeholder: "Seleccione un seguro"
        });


        $("#s-seguro").val([]).trigger("change");
        document.getElementById("s-seguro").classList.remove("is-valid");

        registerStatusFactura.successfulFactura = false;
    }

    if (modalOpened === false) {

        //Inicializamos los select2
        emptyAllSelect2({
            selectSelector: "#s-seguro",
            placeholder: "Cargando",
            parentModal: "#modalRegNormal"
        });

        emptySelect2({
            selectSelector: "#s-consultas",
            placeholder: "Cargando",
            parentModal: "#modalRegNormal",
        });

        const segurosList = await getAll("seguros/consulta");

        dinamicSelect2({
            obj: segurosList ?? [],
            selectSelector: "#s-seguro",
            selectValue: "seguro_id",
            selectNames: ["rif", "nombre"],
            parentModal: "#modalRegNormal",
            placeholder: "Seleccione un seguro"
        });        

        $("#s-seguro").val([]).trigger("change")
        document.getElementById("s-seguro").classList.remove("is-valid");

        $("#s-seguro").on("change", async function (e) {

            let seguro_id = this.value;
            const consultasSeguro = await getById("factura/consultaSeguro/seguro", seguro_id);

            console.log(consultasSeguro);

            $("#s-consultas").empty().select2();

            dinamicSelect2({
                selectSelector: "#s-consultas",
                selectValue: "consulta_seguro_id",
                selectNames: ["consulta_seguro_id", "tipo_servicio", "fecha_ocurrencia"],
                obj: consultasSeguro ?? [],
                parentModal: "#modalRegNormal",
                placeholder: "Seleccione alguna consulta",
                multiple: true
            });            
            
            document.getElementById("s-consultas").disabled = false;
            document.getElementById("s-consultas").classList.remove("is-valid");

        });

        modalOpened = true;
    }
}

if (modalRegister) modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());

// select2OnClick({
//     selectSelector: "#s-seguro",
//     selectValue: "seguro_id",
//     selectNames: ["rif", "nombre"],
//     module: "seguros/consulta",
//     parentModal: "#modalRegNormal",
//     placeholder: "Seleccione un seguro"
// });

// select2OnClick({
//     selectSelector: "#s-consultas",
//     selectValue: "consulta_seguro_id",
//     selectNames: ["consulta_seguro_id", "tipo_servicio", "fecha_ocurrencia"],
//     module: "factura/consultaSeguro/consulta",
//     parentModal: "#modalRegNormal",
//     placeholder: "Seleccione alguna consulta",
//     multiple: true
// });



// dinamicSelect2({
//     obj: [{ id: "efectivo", text: "Efectivo" }, { id: "debito", text: "Debito" }],
//     selectNames: ["text"],
//     selectValue: "id",
//     selectSelector: "#s-metodo-pago",
//     placeholder: "Seleccione un método de pago",
//     parentModal: "#modalRegNormal",
//     staticSelect: true
// });



// function calcularIva(montoInput) {

//     let montoTotal = (parseFloat(montoInput.value) * 0.16) + parseFloat(montoInput.value);
//     document.getElementById("monto_con_iva").value = montoTotal.toFixed(2);
// }

// window.calcularIva = calcularIva;

async function addFMensajeria() {

    const $form = document.getElementById("info-fconsulta"),
        $alert = document.querySelector(".alertConsulta");

    try {
        const formData = new FormData($form),
            consultas = [],
            data = {};
            

        formData.forEach((value, key) => (data[key] = value));

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
       
        let consultasSeguro = formData.getAll("consulta_seguro_id[]");

        consultasSeguro.forEach(e => {
            const consultaSeguro = {
                consulta_seguro_id: e
            }
            consultas.push(consultaSeguro);
        })

        data.consultas = consultas;

        const registroExitoso = await addModule("factura/mensajeria","info-fconsulta",data,"Factura mensajeria registrada correctamente!", "#modalRegNormal", ".alertConsulta");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        registerStatusFactura.successfulFactura = true;
        $('#fMensajeria').DataTable().ajax.reload();
        cleanValdiation("info-fconsulta");

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFMensajeria = addFMensajeria;

