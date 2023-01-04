import listarSeguros, { listarSegurosPorId } from "./listarSeguros.js";

const d = document,
    path = location.pathname.split('/');

export async function mostrarSeguros() {

    try {

        const listadoSeguros = await listarSeguros(),
            $ulSeguros = d.querySelector(".list-seg"),
            $fragment = d.createDocumentFragment();
        console.log(listadoSeguros);



        listadoSeguros.forEach(el => {
            const $li = d.createElement("li"),
                $article = d.createElement("article"),
                $a = d.createElement("a");

            $article.innerText = el.seguro_id;
            $a.dataset.id = el.seguro_id;
            $a.dataset.bsToggle = "modal";
            $a.dataset.bsTarget = "#modalInfo";
            $a.href = "";
            $a.innerHTML = el.nombre;

            $li.appendChild($article);
            $li.appendChild($a);
            $fragment.appendChild($li);
        })

        $ulSeguros.appendChild($fragment);

    } catch (error) {

    }
}

d.addEventListener("DOMContentLoaded", mostrarSeguros);

d.addEventListener("click", async e => {

    if (e.target.matches(".list-seg > li > a")) {

        try {

            const $nombreSeguro = d.getElementById("nombreSeguro"),
                $rifSeguro = d.getElementById("rifSeguro"),
                $direcSeguro = d.getElementById("direcSeguro"),
                $telSeguro = d.getElementById("telSeguro"),
                $porcSeguro = d.getElementById("porcSeguro"),
                $tipoSeguro = d.getElementById("tipoSeguro"),
                $btnActualizar = d.getElementById("btn-actualizar"),
                $btnEliminar = d.getElementById("btn-confirmDelete");

            const json = await listarSegurosPorId(e.target.dataset.id),
            tipoSeguroNombre = ["Acumulativo","Normal"];

            $nombreSeguro.innerText = `${json.nombre}`;
            $rifSeguro.innerText = `${json.rif}`;
            $direcSeguro.innerText = `${json.direccion}`;
            $telSeguro.innerText = `${json.telefono}`;
            $porcSeguro.innerText = `${json.porcentaje}`;
            $tipoSeguro.innerText = `${tipoSeguroNombre[json.tipo_seguro - 1]}`;
            $btnActualizar.value = e.target.dataset.id;
            $btnEliminar.value = e.target.dataset.id

        } catch (error) {

            alert(error);
        }
    }

    if (e.target.matches("#btn-actualizar")) {

        e.preventDefault();
        const $form = d.getElementById("act-seguro");

        try {

            const json = await listarSegurosPorId(e.target.value);

            // Obtener código telefónico
            let $telCod = json.telefono.slice(0, 4),
                $tel = json.telefono.split($telCod);

            //Separar el rif
            let $rif = json.rif.split('-');
            
            for (const option of $form.cod_tel.options) {
                if (option.value === $telCod) {
                    option.defaultSelected = true;
                }
            }

            for (const option of $form.cod_rif.options) {
                if (option.value === $rif[0]) {
                    option.defaultSelected = true;
                }
            }
            
            $form.nombre.value = json.nombre;
            $form.nombre.dataset.secondValue = json.nombre;
            $form.rif.value = $rif[1];
            $form.rif.dataset.secondValue = $rif[1];
            $form.cod_rif.dataset.secondValue = $rif[0];
            $form.direccion.value = json.direccion;
            $form.direccion.dataset.secondValue = json.direccion;
            $form.telefono.value = $tel[1];
            $form.telefono.dataset.secondValue = $tel[1];
            $form.cod_tel.dataset.secondValue = $telCod;
            $form.porcentaje.value = json.porcentaje;
            $form.porcentaje.dataset.secondValue = json.porcentaje;
            $form.tipo_seguro.value = json.tipo_seguro;
            $form.tipo_seguro.dataset.secondValue = json.tipo_seguro;

            const $inputId = d.createElement("input");
            $inputId.type = "hidden";
            $inputId.value = e.target.value;
            $inputId.name = "seguro_id";
            $form.appendChild($inputId);

        } catch (error) {

            alert(error);
        }
    }

    if (e.target.matches("#btn-eliminar")) {

    }
})