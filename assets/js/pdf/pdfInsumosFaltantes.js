import getAll from "../global/getAll.js";


const data = await getAll("insumos/consulta");
data.sort((a, b) => a.cantidad - b.cantidad);

data.forEach((e, i) => {
    document.querySelector(".tabla > tbody").innerHTML += `
        <tr class="insumo">
            <td>${e.nombre}</td>
            <td>${e.cantidad} unidades</td>
        </tr>
        <tr style="height: 30px"></tr>
    `; 

    if(i === 10) return;
})

window.print();