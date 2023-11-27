import getAll from "../global/getAll.js";


const insumosList = await getAll("insumos/consulta");
const data = insumosList.filter(insumos => insumos.cantidad < insumos.cantidad_min);

data.forEach((e, i) => {
    document.querySelector(".tabla > tbody").innerHTML += `
        <tr class="insumo">
            <td colspan="2">${e.nombre}</td>
            <td colspan="1">${e.cantidad_min} unidades</td>
            <td colspan="1">${e.cantidad} unidades</td>
        </tr>
        <tr style="height: 30px"></tr>
    `; 

    if(i === 10) return;
})

window.print();