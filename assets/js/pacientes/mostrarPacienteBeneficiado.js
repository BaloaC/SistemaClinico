import deleteElementByClass from "../global/deleteElementByClass.js";

export default function mostrarPacienteBeneficiado(titulares) {

    if (titulares.length > 0) {

        let template = "";

        titulares.forEach(el => {

            let tipo_familiar;

            switch(el.tipo_familiar){
                case "1": tipo_familiar = "Padre/Madre"; break;
                case "2": tipo_familiar = "Representante"; break;
                case "3": tipo_familiar = "Primo/a"; break;
                case "4": tipo_familiar = "Hermano/a"; break;
                case "5": tipo_familiar = "Esposo/a"; break;
                case "6": tipo_familiar = "Tío/a"; break;
                case "7": tipo_familiar = "Sobrino/a"; break;
            }

            template += `
                <div class="row align-items-center newInput">
                    <hr>
                    <div class="col-3 col-md-1">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeletePacienteTitular" class="btn" onclick="deletePacienteTitular(${el.titular_beneficiado_id})"><i class="fas fa-times m-0"></i></button>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="titular">Titular</label>
                        <input type="text" name="nombre_titular" class="form-control mb-3" value="${el.cedula + " - " + el.nombre + " " + el.apellidos}" disabled>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="tipo_relacion">Tipo de relación</label>
                        <input type="text" name="tipo_relacion" class="form-control mb-3" value="${el.tipo_relacion === "1" ? "Seguro" : "Natural"}" disabled>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="tipo_familiar">Tipo de familiar</label>
                        <input type="text" name="tipo_familiar" class="form-control mb-3" value="${tipo_familiar}" disabled>
                    </div>
                </div>
            `;

            // Para poder añadir otro titular se require del paciente_beneficiado_id
            template += `<input type="hidden" name="paciente_beneficiado_id" class="newInput" value="${el.paciente_beneficiado_id}">`
        })

        deleteElementByClass("newInput");
        document.getElementById("submenu-beneficiado-title").insertAdjacentHTML("afterend", template);
        
    } else{
        deleteElementByClass("newInput");
    }
    
}