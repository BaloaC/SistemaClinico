export default function concatItems(items, propItem, noneMessage, separator = ",", propItem2 = null, endText = null) {
    let concatString = "";
    if (items === undefined || items.length === 0) {
        concatString = noneMessage;
    } else {
        items.forEach(item => { 
            console.log(item[propItem]  + `${separator} `);
            concatString += item[propItem] + `${propItem2 !== null ? ` $${item[propItem2]}` : ""}` + `${separator} ${endText !== null ? endText : ""}`; 
        });
        concatString = concatString.trimEnd().slice(0, -1);
    }
    return concatString;
}
