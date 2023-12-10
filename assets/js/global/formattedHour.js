export default function formattedHour(element) {
   
    const now = new Date();

    // Formatea la hora actual con los primeros ceros
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = "00";

    element.value = `${hours}:${minutes}:${seconds}`;
}