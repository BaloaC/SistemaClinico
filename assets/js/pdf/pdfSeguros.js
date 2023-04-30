import getAll from "../global/getAll.js";

const template = document.getElementById("seguro-template").content;
const fragment = document.createDocumentFragment();
const data = await getAll("seguros/consulta");


data.forEach(e => {
    template.getElementById("nombre").textContent = e.nombre;
    template.getElementById("rif").textContent = e.rif;
    template.getElementById("telefono").textContent = e.telefono;
    template.getElementById("direccion").textContent = e.direccion;

    let clone = document.importNode(template, true);
    fragment.appendChild(clone);
})

document.querySelector(".seguros-container").appendChild(fragment);

window.print();