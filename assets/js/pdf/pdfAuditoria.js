import getAll from "../global/getAll.js";

const data = location.pathname.split("/")[4].split("-");


let infoAuditoria;
if(data[0] === "0"){
    infoAuditoria = await getAll(`auditoria/consulta`)
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