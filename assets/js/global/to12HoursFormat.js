export default function to12HourFormat(fullHour) {

    let hour = parseInt(fullHour.split(":")[0]);
    let minutes = fullHour.split(":")[1];
    let parsedHour = "";

    // Si la hora es menor que 12, el formato es AM, sino PM
    if(hour < 12){
        parsedHour = hour < 10 ? `0${hour}:${minutes} AM` : `${hour}:${minutes} AM`;
    } else if(hour > 12) {
        hour = hour - 12;
        parsedHour = hour < 10 ? `0${hour}:${minutes} PM` : `${hour}:${minutes} PM`;
    }

    return parsedHour;
}
