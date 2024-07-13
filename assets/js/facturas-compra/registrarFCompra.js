import addModule from "../global/addModule.js";
import cleanValdiation from "../global/cleanValidations.js";
import deleteElementByClass from "../global/deleteElementByClass.js";

async function addFCompra() {

    const $form = document.getElementById("info-fcompra"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        const $insumos = document.querySelectorAll(".insumo-id");
        const $insumosUnid = document.querySelectorAll(".insumo-unid");
        const $insumosUPrecio = document.querySelectorAll(".insumo-uprecio");
        const $insumosTPrecio = document.querySelectorAll(".monto-total-p");
        const $actualizarPrecio = document.querySelectorAll(".actualizarPrecioInsumo");
        let monto_sin_iva = document.getElementById("monto-sin-iva").textContent;
        monto_sin_iva = monto_sin_iva.substring(0, monto_sin_iva.length - 3);
        let monto_con_iva = document.getElementById("monto-total").textContent;
        monto_con_iva = monto_con_iva.substring(0, monto_con_iva.length - 3);
        let excento = document.getElementById("iva").textContent;
        excento = excento.substring(0, excento.length - 3);
        const total_productos = document.getElementById("productos-totales").textContent;
        const insumos = [];
        
        const insumoSet = new Set();

        $insumos.forEach((value, key) => {

            const insumoValue = $insumos[key].value;

            // Validamos que no exista el mismo insumo dentro de la factura
            if (insumoSet.has(insumoValue)) {
                throw { message: "No es posible ingresar el mismo insumo verifique e intente nuevamente" };
            }

            insumoSet.add(insumoValue);

            if($insumosUPrecio[key].value <=  0) throw { message: "Ningún precio unitario debe estar vacío" };
            if($insumosUnid[key].value <= 0) throw { message: "Debe colocar al menos 1 unidad por insumo" };

            const insumo = {
                insumo_id: value.value,
                unidades: $insumosUnid[key].value,
                precio_unit_bs: $insumosUPrecio[key].value,
                precio_total_bs: $insumosTPrecio[key].textContent.substring(0, $insumosTPrecio[key].textContent.length - 3),
                actualizar_precio: $actualizarPrecio[key].checked
            }

            delete data[`${$actualizarPrecio[key].name}`];
            insumos.push(insumo);
        })
     
        delete data.actualizar_precio;

        data.insumos = insumos;
        data.monto_con_iva = monto_con_iva;
        data.monto_sin_iva = monto_sin_iva;
        data.total_productos = total_productos;
        data.excento = excento;

        if (!$form.checkValidity()) { $form.reportValidity(); return; }

        const registroExitoso = await addModule("factura/compra", "info-fcompra", data, "Factura compra registrada correctamente!");

        if (!registroExitoso.code) throw { result: registroExitoso.result };

        $("#s-proveedor").val([]).trigger("change.select2");
        $("#s-insumo").val([]).trigger("change.select2");
        let formCompra = document.getElementById("info-fcompra");
        $(".actualizarPrecio-insumo").fadeOut("slow");
        formCompra.reset();
        cleanValdiation("info-fcompra");
        deleteElementByClass("newInput");
        document.querySelector("td > .monto-total-p").textContent = "0.00 Bs";
        document.getElementById("productos-totales").textContent = "0";
        document.getElementById("monto-sin-iva").textContent = "0.00 Bs";
        document.getElementById("iva").textContent = "0.00 Bs";
        document.getElementById("monto-total").textContent = "0.00 Bs";
        $('#fCompra').DataTable().ajax.reload();
        document.querySelectorAll(".insumo-id")[0].classList.remove("is-valid");
        $("#s-proveedor").removeClass("is-valid");

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

