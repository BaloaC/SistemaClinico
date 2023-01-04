import dinamicSelect from "../global/dinamicSelect.js";
import listarSeguros, { listarSegurosPorId } from "../seguros/listarSeguros.js";
import listarEmpresas, { listarEmpresaPorId } from "./listarEmpresas.js";

const d = document,
    path = location.pathname.split('/');

async function getEmpresa(id) {
    try {

        const $nombreEmpresa = d.getElementById("nombreEmpresa"),
            $rifEmpresa = d.getElementById("rifEmpresa"),
            $nombreSeguro = d.getElementById("nombreSeguro"),
            $direcEmpresa = d.getElementById("direcEmpresa"),
            $btnActualizar = d.getElementById("btn-actualizar"),
            $btnEliminar = d.getElementById("btn-confirmDelete");

        const json = await listarEmpresaPorId(id);

        $nombreEmpresa.innerText = `${json[0].nombre_empresa}`;
        $rifEmpresa.innerText = `${json[0].rif}`;
        $direcEmpresa.innerText = `${json[0].direccion}`;
        $nombreSeguro.innerText = `${json[0].nombre}`;
        $btnActualizar.value = id;
        $btnEliminar.value = id;

    } catch (error) {

        alert(error);
    }
}

window.getEmpresa = getEmpresa;

export async function mostrarEmpresas() {

    try {

        const listadoEmpresas = await listarEmpresas(),
            $cardTemplate = d.getElementById("card-template").content,
            $empresasContainer = d.getElementById("empresas-container"),
            $fragment = d.createDocumentFragment();

        // ! 0 = para empresas sin seguro afiliado, 1 = seguros afiliados empresas
        listadoEmpresas.forEach(el => {

            let $nombreEmpresa = $cardTemplate.querySelector("h3"),
                $cardContainer = $cardTemplate.querySelector(".card-container"),
                $rif = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
                $nombreSeguro = $cardTemplate.querySelector(".list-group > li:nth-child(2) > b");

            $nombreEmpresa.textContent = el.nombre_empresa;
            $rif.textContent = el.rif;
            $nombreSeguro.textContent = el.nombre;
            $cardContainer.setAttribute("onclick", `getEmpresa(${el.empresa_id})`);

            let clone = document.importNode($cardTemplate, true);
            $fragment.appendChild(clone);
        })

        $empresasContainer.replaceChildren();
        $empresasContainer.appendChild($fragment);

    } catch (error) {
        console.log(error);
    }
}

// async function cargarSelect() {
//     try {

//         const $form = d.getElementById("info-empresa"),
//             $actForm = d.getElementById("act-empresa"),
//             $select = d.createElement("select"),
//             $defaultOption = d.createElement("option"),
//             $fragment = d.createDocumentFragment(),
//             seguros = await listarSeguros();


//             // dinamicSelect(seguros,"nombre","seguro_id","cod-rif");

//         //Estableciendo configuraciones iniciales del select
//         $select.setAttribute("name", "seguro_id");
//         // $select.setAttribute("id","act-seguro");
//         $select.classList.add("form-control");
//         $defaultOption.textContent = "Seleccione un seguro";
//         $select.appendChild($defaultOption);


//         seguros.forEach(el => {

//             const $option = d.createElement("option");
//             $option.value = el.seguro_id;
//             $option.textContent = el.nombre;

//             console.log(el.seguro_id, el.nombre)

//             $fragment.appendChild($option);
//         })


//         $select.appendChild($fragment);
//         let $select2 = $select.cloneNode(true) //document.importNode($select,true);
//         $form.appendChild($select);
//         $actForm.appendChild($select2);

//     } catch (error) {
//         console.log(error)
//         alert(error);
//     }
// }



d.addEventListener("DOMContentLoaded", e => {
    mostrarEmpresas();
});

d.addEventListener("click", async function (e) {

    if (e.target.matches("#seguro_id") && e.target.dataset.active == 0) {

        const seguros = await listarSeguros();
        dinamicSelect(seguros, "nombre", "seguro_id", e.target);
        e.target.dataset.active = 1;
    }
})