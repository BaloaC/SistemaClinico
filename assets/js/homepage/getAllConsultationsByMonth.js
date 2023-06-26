import getAll from "../global/getAll.js";
import { series, title, xAxis } from "./especialidadesGraph.js";

export default async function getAllConsultationsByMonth(bySpeciality) {
    const consultations = await getAll("consultas/consulta");
    let [oneSeven, eightFiveteen, sixTeenTwentytwo, TwentythreeTwentynine] = [0, 0, 0, 0];
    
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
            case (dia >= 1 && dia <= 7) : oneSeven++; break;
            case (dia >= 8 && dia <= 15) : eightFiveteen++; break;
            case (dia >= 16 && dia <= 22) : sixTeenTwentytwo++; break;
            case (dia >= 23 && dia <= 31) : TwentythreeTwentynine++; break;
        }
    })

    const allConsultations = [
        { meses: "1 - 7", value: oneSeven },
        { meses: "7 - 14", value: eightFiveteen },
        { meses: "14 - 21", value: sixTeenTwentytwo },
        { meses: "21 - 31", value: TwentythreeTwentynine },
    ];

    xAxis.data.setAll(allConsultations);
    series.data.setAll(allConsultations);
}