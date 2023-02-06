export default function concatItems(items, propItem, noneMessage) {
    let concatString = "";
    if (items.length === 0) {
        concatString = noneMessage;
    } else {
        items.forEach(item => { concatString += item[propItem] + ", "; });
        concatString = concatString.trimEnd().slice(0, -1);
    }
    return concatString;
}