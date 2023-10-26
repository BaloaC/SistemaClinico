export default function cleanValdiation(elementId){ 
    Array.from(document.getElementById(elementId)?.elements)?.forEach(element => {
        element.classList.remove('valid');
    })
}

