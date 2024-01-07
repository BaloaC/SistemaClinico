export default function dinamicSelect(obj, selectName, selectValue, selectSelector) {
    try {
        obj.forEach(el => {
            
            let template = `
                <option value="${el[selectValue]}">
                    ${el[selectName]}
                </option>
            `
            selectSelector.innerHTML += template;
        });
    } catch (error) {
        console.log(error);
    }
}