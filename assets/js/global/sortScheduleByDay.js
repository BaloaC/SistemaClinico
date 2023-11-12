export default function sortScheduleByDay(schedule) {
    
    const daysSorted = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

    const scheduleSorted = schedule.sort((a, b) => {

        const dayA = daysSorted.indexOf(a.dias_semana.toLowerCase());
        const dayB = daysSorted.indexOf(b.dias_semana.toLowerCase());

        if (dayA < dayB) { return -1; } 
        else if (dayA > dayB) { return 1;} 
        else { return 0; }
    });

    return scheduleSorted;
}