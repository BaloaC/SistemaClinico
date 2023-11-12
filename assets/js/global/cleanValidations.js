export default function cleanValdiation(elementId){ 
    Array.from(document.getElementById(elementId)?.elements)?.forEach(element => {
        element.classList.remove('valid');
        element.classList.remove('invalid');
        element.classList.remove('is-invalid');
        element.classList.remove('is-valid');
    })
}

