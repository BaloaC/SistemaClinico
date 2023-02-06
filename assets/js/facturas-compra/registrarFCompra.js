import addModule from "../global/addModule.js";
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
            $insumosTPrecio = document.querySelectorAll(".insumo-tprecio"),
            insumos = [];

        $insumos.forEach((value, key) => {
            const insumo = {
                insumo_id: value.value,
                unidades: $insumosUnid[key].value,
                precio_unit: $insumosUPrecio[key].value,
                precio_total: $insumosTPrecio[key].value
            }
            insumos.push(insumo);
        })
        data.insumos = insumos;
        console.log(data.insumos);

        // TODO: Validar los inputs del paciente

        // if (isNaN(data.rif) || data.rif.length !== 9) throw { message: "El RIF ingresado es inválido" };

        // if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "El nombre ingresado no es válido" };

        // data.rif = data.cod_rif + "-" + data.rif;

        await addModule("factura/compra","info-fcompra",data,"Factura compra registrada correctamente!");
        $('#fCompra').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addFCompra = addFCompra;

