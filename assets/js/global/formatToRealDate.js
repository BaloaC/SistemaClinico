export default function formatToRealDate(date) {

  if(!date) return undefined;

  const [datePart] = date.split(' ');

  // Luego, dividimos la parte de la fecha en año, mes y día
  const [year, month, day] = datePart.split('-');

  // Aseguramos que cada parte de la fecha está correctamente formateada
  const formattedYear = year || '0000';
  const formattedMonth = (month || '00').padStart(2, '0');
  const formattedDay = (day || '00').padStart(2, '0');

  return `${formattedDay}-${formattedMonth}-${formattedYear}`;
}