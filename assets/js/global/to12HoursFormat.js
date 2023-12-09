export default function to12HourFormat(fullHour) {

    let hour = parseInt(fullHour.split(":")[0]);
    let minutes = fullHour.split(":")[1];
    let parsedHour = "";

    // Si la hora es menor que 12, el formato es AM, sino PM

    switch (hour) {
        case 0:
            parsedHour = `12:${minutes} AM`;
            break;
        case 12:
            parsedHour = `${hour}:${minutes} PM`;
            break;
        default:
            parsedHour = hour < 12 ? `${hour}:${minutes} AM` : `${hour - 12}:${minutes} PM`;
    }

    return parsedHour;
}
