import getAll from "../global/getAll.js";


const data = await getAll("insumos/consulta");
data.sort((a, b) => a.stock - b.stock);

data.forEach((e, i) => {
    document.querySelector(".tabla > tbody").innerHTML += `
        <tr class="insumo">
            <td>${e.nombre}</td>
            <td>${e.stock} unidades</td>
        </tr>
        <tr style="height: 30px"></tr>
    `; 

    if(i === 10) return;
})

window.print();