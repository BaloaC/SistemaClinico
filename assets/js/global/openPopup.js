export default function openPopup(rute){

    let basePath = `${location.origin}/${location.pathname.split("/")[1]}/${rute}`;
    const openPopup = open(basePath,"_blank","popup=true");

    openPopup.moveTo(0,0);
    openPopup.resizeTo(screen.availWidth,screen.availHeight);
}    

window.openPopup = openPopup;