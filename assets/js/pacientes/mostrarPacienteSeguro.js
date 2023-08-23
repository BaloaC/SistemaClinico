import deleteElementByClass from "../global/deleteElementByClass.js";

export default function mostrarPacienteSeguro(seguros){
    
    if(seguros.length > 0){

        let template = "";

        seguros.forEach(el => {
            template += `
                <div class="row align-items-center newInput">
                    <hr>
                    <div class="col-3 col-md-1">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeletePacienteSeguro" class="btn" onclick="deletePacienteSeguro(${el.paciente_seguro_id})"><i class="fas fa-times m-0"></i></button>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="titular">Nombre Seguro</label>
                        <input type="text" name="nombre_seguro" class="form-control mb-3" value="${el.nombre_seguro}" disabled>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="tipo_relacion">Nombre Empresa</label>
                        <input type="text" name="nombre_empresa" class="form-control mb-3" value="${el.nombre_empresa}" disabled>
                    </div>
                </div>
            `;
        })

        deleteElementByClass("newInput");
        document.getElementById("submenu-seguro-title").insertAdjacentHTML("afterend", template);
        
    } else{
        deleteElementByClass("newInput");
    }
    
}