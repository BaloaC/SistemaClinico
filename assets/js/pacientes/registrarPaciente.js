import addModule from "../global/addModule.js";
import getAge from "../global/getAge.js";

async function addPaciente() {

    const $form = document.getElementById("info-paciente"),
        $alert = document.querySelector(".alert");

    try {
        const formData = new FormData($form),
            data = {},
            seguro = [],
            titular = [];

        formData.forEach((value, key) => (data[key] = value));

        let edad = data.fecha_nacimiento.split("-");
        data.edad = getAge(edad[0], edad[1], edad[2]);


        // Crear objeto depediendo el tipo de paciente
        if(data.tipo_paciente == 3){
            let seguros = formData.getAll("seguro[]");
            seguros.forEach(el => {
                const seguro_id = {
                    seguro_id: el,
                    empresa_id: data.empresa_id,
                    tipo_seguro: data.tipo_seguro,
                    cobertura_general: data.cobertura_general,
                    fecha_contra: data.fecha_contra,
                    saldo_disponible: data.saldo_disponible
                }
                seguro.push(seguro_id);
            })

            if(seguros.length === 0) throw {message: "No se ha enviado ningún seguro"};
            data.seguro = seguro;
        
        } else if(data.tipo_paciente == 4){
            const titulares = document.querySelectorAll(".titular"),
            relacion = document.querySelectorAll(".relacion");

            titulares.forEach((value, key)  => {
                // TODO: Validar que ambos valores se envien
                console.log(relacion[key].value);
                const titular_id = {
                    paciente_id: value.value,
                    tipo_relacion: relacion[key].value
                }
                titular.push(titular_id);
            })

            if(titular.length === 0) throw {message: "No se ha seleccionado ningún titular"};
            data.titular = titular;
        }

        // TODO: Validar los inputs del paciente

        if (!$form.checkValidity()) { $form.reportValidity(); return; }
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.nombre))) throw { message: "Los nombre ingresado no es válido" };
        if (!(/^[A-Za-zÑñÁáÉéÍíÓóÚúÜü\s]+$/.test(data.apellidos))) throw { message: "Los apellidos ingresado no es válido" };
        if (!(/^\d{6,8}$/.test(data.cedula))) throw { message: "La cédula no es válida" };
        if (!(/^(?=.*[^\s])(?=.*[a-zA-Z0-9 @#+_,-])[a-zA-Z0-9 @#+_,-]{1,255}$/.test(data.direccion))) throw { message: "La direccion ingresada no es válida" };
        if (isNaN(data.telefono) || data.telefono.length != 7) throw { message: "El número ingresado no es válido" };
        if (isNaN(data.cod_tel) || data.cod_tel.length != 4) throw { message: "El número ingresado no es válido" };

        data.telefono = data.cod_tel + data.telefono;
        
    
        await addModule("pacientes","info-paciente",data,"Paciente registrado correctamente!");

        $('#pacientes').DataTable().ajax.reload();

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }
}

window.addPaciente = addPaciente;


