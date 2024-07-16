export default function truncateToTwoDecimals(num) {
    const numStr = num.toString();
    const decimalIndex = numStr.indexOf('.');

    // Si no hay punto decimal, el número ya es entero, así que no necesitamos truncar
    if (decimalIndex === -1) {
        return `${num}.00`;
    }

    // Tomar la parte entera y los primeros dos dígitos decimales
    const truncatedStr = numStr.slice(0, decimalIndex + 3);
    
    return truncatedStr;
}