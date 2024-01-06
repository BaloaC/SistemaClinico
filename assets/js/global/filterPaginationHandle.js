const removeAccents = (text) => {
    const accents = { 'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u' };
    return text.replace(/[áéíóú]/g, letter => accents[letter]);
};


export const filterPaginationHandle = (inputSearch, objectList, propertiesNames) => {

    const searchTerm = removeAccents(inputSearch.value.toLowerCase());

    const fullName = propertiesNames.map(property => objectList[property]).join(" ");
    const fullNameWithoutAccents = removeAccents(fullName.toLowerCase());

    return fullNameWithoutAccents.includes(searchTerm);
}