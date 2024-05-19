async function updateCita(citaObject) {

    const $form = document.getElementById("act-cita");
    
    try {
        console.log(citaObject);

        let montoConsulta = citaObject.costo_especialidad;
        let montoTotal = 0;
        let examenes = "";
        let tbodyExamenes = document.querySelector(".examenesCitaTbody")

        if(citaObject?.examenes?.length > 0){

            citaObject.examenes.map((examen, item) => {
                examenes += `
                    <tr class="examen_id_${examen.examen_id}">
                        <td><i class="fas fa-trash"></i></td>
                        <td scope="row"><input type="checkbox" class="form-check-input examenCita${examen.examen_id} examenCubierto examenCubiertoPorSeguro" data-id="${examen.examen_id}" onchange="checkExamenHandler(this)" disabled></td>
                        <td class="examenPrice">$${examen.precio_examen_usd}</td>
                        <td>${examen.nombre}</td>
                    </tr>
                `;
            });

            tbodyExamenes.innerHTML = examenes;
            $(".examenesCitaContainer").fadeIn("slow");

        } else {

            tbodyExamenes.innerHTML = "";
            $(".examenesCitaContainer").fadeOut("slow");
        }

        document.getElementById("costoConsulta").innerText = `$${montoConsulta}`;

        const $inputId = document.createElement("input");
        $inputId.type = "hidden";
        $inputId.value = citaObject.cita_id;
        $inputId.name = "cita_id";
        $form.appendChild($inputId);

    } catch (error) {
        console.log(error);
    }
}

window.updateCita = updateCita;