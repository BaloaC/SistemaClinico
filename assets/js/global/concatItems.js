export default function concatItems(items, propItem, noneMessage, separator = ",") {
    let concatString = "";
    if (items === undefined || items.length === 0) {
        concatString = noneMessage;
    } else {
        items.forEach(item => { concatString += item[propItem] + `${separator} `; });
        concatString = concatString.trimEnd().slice(0, -1);
    }
    return concatString;
}
