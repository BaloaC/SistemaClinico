async function updateCita(citaObject) {

    const $form = document.getElementById("act-cita");
    
    try {

        let montoConsulta = 0;
        let montoTotal = 0;
        let examenes = "";
        let tbodyExamenes = document.querySelector(".examenesCitaTbody")

        if(citaObject?.examenes?.length > 0){

            citaObject.examenes.map((examen, item) => {
                examenes += `
                    <tr class="examen_id_${examen.examen_id}">
                        <td scope="row"><input type="checkbox" class="examenCita${item}"></td>
                        <td scope="row"><input type="checkbox" class="examenCita${item}"></td>
                        <td>$${examen.precio_examen_usd}</td>
                        <td>${examen.nombre}</td>
                    </tr>
                `;
            });

            tbodyExamenes.innerHTML = examenes;
            $(".examenesCitaContainer").fadeIn("slow");
        }

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