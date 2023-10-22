export default function scrollTo(element){
    const elementTop = document.getElementById(element);

    if(elementTop !== null){
        elementTop.scrollTo({
            top: 0,
            bottom: elementTop.scrollHeight,
            behavior: 'smooth'
        });
    }
}
