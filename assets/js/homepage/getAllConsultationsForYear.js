import getAll from "../global/getAll.js";
import { series, xAxis } from "./especialidadesGraph.js";

export default async function getAllConsultationsForYear(bySpeciality) {
    const consultations = await getAll("consultas/consulta");
    let [enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    
    if (consultations == undefined) {
        document.getElementById('chartdiv').innerHTML = `<h4 class="text-gray justify-content-center fs-4 d-flex align-items-center h-100" >No hay consultas disponibles por los momentos</h4>`
        return
    }

    let consultationsYear;
    if(bySpeciality === "all"){
        consultationsYear = consultations.filter(consultation => new Date(consultation.fecha_consulta).getFullYear() === new Date().getFullYear() );
    } else{
        consultationsYear = consultations.filter(consultation => new Date(consultation.fecha_consulta).getFullYear() === new Date().getFullYear() && consultation.especialidad_id == bySpeciality);
    }

    consultationsYear.forEach(el => {
        // console.log(el.fecha_consulta);
        let mes = new Date(el.fecha_consulta).getMonth()
        // console.log(mes);
        switch (mes) {
            case 0: enero++; break;
            case 1: febrero++; break;
            case 2: marzo++; break;
            case 3: abril++; break;
            case 4: mayo++; break;
            case 5: junio++; break;
            case 6: julio++; break;
            case 7: agosto++; break;
            case 8: septiembre++; break;
            case 9: octubre++; break;
            case 10: noviembre++; break;
            case 11: diciembre++; break;
        }
    })

    const allConsultations = [
        { meses: "Enero", value: enero },
        { meses: "Febrero", value: febrero },
        { meses: "Marzo", value: marzo },
        { meses: "Abril", value: abril },
        { meses: "Mayo", value: mayo },
        { meses: "Junio", value: junio },
        { meses: "Julio", value: julio },
        { meses: "Agosto", value: agosto },
        { meses: "Septiembre", value: septiembre },
        { meses: "Octubre", value: octubre },
        { meses: "Noviembre", value: noviembre },
        { meses: "Diciembre", value: diciembre },
    ];

    console.log('con',allConsultations)

    xAxis.data.setAll(allConsultations);
    series.data.setAll(allConsultations);
}