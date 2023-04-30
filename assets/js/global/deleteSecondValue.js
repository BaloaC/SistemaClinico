export default function deleteSecondValue(selector,data) {
    const inputs = document.querySelectorAll(selector);

    inputs.forEach(e => {
        if (e.dataset.secondValue === e.value) {
            delete data[e.name];
        }
    })

    return data;
}