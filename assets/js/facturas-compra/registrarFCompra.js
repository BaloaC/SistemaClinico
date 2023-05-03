import addModule from "../global/addModule.js";
import deleteElementByClass from "../global/deleteElementByClass.js";
import getAge from "../global/getAge.js";

async function addFCompra() {

    const $form = document.getElementById("info-fcompra"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const $insumos = document.querySelectorAll(".insumo-id"),
            $insumosUnid = document.querySelectorAll(".insumo-unid"),
            $insumosUPrecio = document.querySelectorAll(".insumo-uprecio"),
            $insumosTPrecio = document.querySelectorAll(".monto-total-p"),
            monto_sin_iva = document.getElementById("monto-sin-iva").textContent.slice(1),
            monto_con_iva = document.getElementById("monto-total").textContent.slice(1),
            excento = document.getElementById("iva").textContent.slice(1),
            total_productos = document.getElementById("productos-totales").textContent,
            insumos = [];

        // console.log($insumos);

        $insumos.forEach((value, key) => {

            // console.log($insumos[key + 1]);
            // if($insumos[key + 1] !== undefined){
            //     if($insumos[key].value === $insumos[key + 1].value) throw { message: "No es posible ingresar el mismo insumom verifique e intente nuevamente" }
            // }


            const insumo = {
                insumo_id: value.value,
                unidades: $insumosUnid[key].value,
                precio_unit: $insumosUPrecio[key].value,
                precio_total: $insumosTPrecio[key].textContent.slice(1)
            }
            insumos.push(insumo);
            
            // console.log(insumos.every(el => el === el));
    
            
        })
        // let count = 0;
        // console.log(insumos.every(el => { 
             
        //     if(el.insumo_id === el.insumo_id){
        //         count++;
        //     }
        //     console.log(count);
        //     if(count > 1){
        //         return true;
        //     }
        // }));
        data.insumos = insumos;
        data.monto_con_iva = monto_con_iva;
        data.monto_sin_iva = monto_sin_iva;
        data.total_productos = total_productos;
        data.excento = excento;


        // TODO: Validar los inputs del paciente

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        await addModule("factura/compra","info-fcompra",data,"Factura compra registrada correctamente!");
        let formCompra = document.getElementById("info-fcompra");
        formCompra.reset();
        deleteElementByClass("newInput");
        $("#s-proveedor").val([]).trigger('change');
        $("#s-insumo").val([]).trigger('change');
        document.querySelector("td > .monto-total-p").textContent = "$0.00";
        document.getElementById("productos-totales").textContent = "0";
        document.getElementById("monto-sin-iva").textContent = "$0.00";
        document.getElementById("iva").textContent = "$0.00";
        document.getElementById("monto-total").textContent = "$0.00";
        $('#fCompra').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 1500)
    }
}

window.addFCompra = addFCompra;

