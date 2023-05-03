export default function deleteElementByClass(className) {

    const elements = document.querySelectorAll(`.${className}`);
    elements.forEach((element) => element.remove());
}