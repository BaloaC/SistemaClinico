import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4];
console.log("🍓 ~ file: pdfAuditoria.js:4 ~ data:", data)


const url = data.split("00000");
console.log("🍓 ~ file: pdfAuditoria.js:6 ~ url:", url)

let infoAuditoria;
if(data.split("00000")[1] === ""){
    infoAuditoria = await getAll(`auditoria/consulta`)
} else {
    infoAuditoria = await getAll(`auditoria/consulta${data.split("00000")[1]}`)
}

let registros = "";

if (infoAuditoria?.length > 0) {

    infoAuditoria.sort((a, b) => b.auditoria_id - a.auditoria_id);

    infoAuditoria.forEach(registro => {        
        registros += `
            <tr>
                <td>${registro.auditoria_id}</td>
                <td>${registro.nombre_usuario}</td>
                <td>${registro.accion}</td>
                <td>${registro.descripcion}</td>
                <td>${registro.fecha_creacion}</td>
            </tr>
        `;
    });
}

document.getElementById("auditoria-registros").innerHTML = registros;

window.print();