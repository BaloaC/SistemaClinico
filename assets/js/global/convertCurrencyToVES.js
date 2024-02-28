export default function convertCurrencyToVES(amount){
    return Number(amount).toLocaleString("es-VE", { style: "decimal", minimumFractionDigits: 2 });
}