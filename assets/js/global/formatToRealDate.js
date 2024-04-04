export default function formatToRealDate(date) {
  const dateFomat = new Date(date);
  const age = String(dateFomat.getFullYear());
  const month = String(dateFomat.getMonth() + 1).padStart(2, '0'); // Añadimos un cero a la izquierda si es necesario
  const day = String(dateFomat.getDate()).padStart(2, '0');

  return `${day == "NaN" ? "00" : day}-${month == "NaN" ? "00" : month}-${age == "NaN" ? "0000" : age}`;
}
