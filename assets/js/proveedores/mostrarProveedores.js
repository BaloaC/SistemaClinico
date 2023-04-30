import getAll from "../global/getAll.js";

export async function mostrarProveedores() {

    // try {

    //     const listadoProveedores = await getAll("proveedores/consulta"),
    //         $cardTemplate = document.getElementById("card-template").content,
    //         $proveedoresContainer = document.getElementById("proveedores-container"),
    //         $fragment = document.createDocumentFragment();

    //         listadoProveedores.forEach(el => {

    //         let $nombreProveedor = $cardTemplate.querySelector("h3"),
    //             $ubicacion = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
    //             $btnActualizar = $cardTemplate.querySelector(".list-group li:nth-child(2) #btn-actualizar"),
    //             $btnEliminar = $cardTemplate.querySelector(".list-group li:nth-child(2) #btn-eliminar");

    //         $nombreProveedor.textContent = el.nombre;
    //         $ubicacion.textContent = el.ubicacion;
    //         $btnActualizar.setAttribute("onclick", `updateProveedor(${el.proveedor_id})`);
    //         $btnEliminar.setAttribute("onclick", `deleteProveedor(${el.proveedor_id})`);

    //         let clone = document.importNode($cardTemplate, true);
    //         $fragment.appendChild(clone);
    //     })

    //     $proveedoresContainer.replaceChildren();
    //     $proveedoresContainer.appendChild($fragment);

    // } catch (error) {
    //     console.log(error);
    // }
}

// addEventListener("DOMContentLoaded", mostrarProveedores);