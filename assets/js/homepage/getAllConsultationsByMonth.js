import getAll from "../global/getAll.js";
import { series, title, xAxis } from "./especialidadesGraph.js";

export default async function getAllConsultationsByMonth(bySpeciality) {
    const consultations = await getAll("consultas/consulta");
    let [oneNine, teenNineteen, twentyThreetyone] = [0, 0, 0];
    
    if (consultations == undefined || consultations.length <= 0) {
        let mensajeEspecialidad = document.getElementsByClassName('text-no-graph')[0];
        if (mensajeEspecialidad.classList.contains('d-none')) {
            mensajeEspecialidad.classList.remove('d-none')
        } 
    }

    let consultationsYear;
    if(bySpeciality === "all"){
        consultationsYear = consultations.filter(consultation => new Date(consultation.fecha_consulta).getMonth() === new Date().getMonth());
    } else{
        consultationsYear = consultations.filter(consultation => new Date(consultation.fecha_consulta).getMonth() === new Date().getMonth() && consultation.especialidad_id == bySpeciality);
    }
    
    console.log(consultationsYear);
    consultationsYear.forEach(el => {
        
        let dia = new Date(el.fecha_consulta).getDate() + 1;

        switch (true) {
            case (dia >= 1 && dia <= 9) : oneNine++; break;
            case (dia >= 10 && dia <= 19) : teenNineteen++; break;
            case (dia >= 20 && dia <= 31) : twentyThreetyone++; break;
        }
    })

    const allConsultations = [
        { meses: "1 - 9", value: oneNine },
        { meses: "10 - 19", value: teenNineteen },
        { meses: "20 - 31", value: twentyThreetyone },
    ];

    xAxis.data.setAll(allConsultations);
    series.data.setAll(allConsultations);
}