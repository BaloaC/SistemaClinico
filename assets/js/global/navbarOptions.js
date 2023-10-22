import Cookies from "../../libs/jscookie/js.cookie.min.js";

let rol = Cookies.get("rol");
if(rol === undefined || rol === null) rol = 0;

const opcionesRol = Array.from(document.querySelectorAll(`.rol-${rol}`));

document.getElementById("navBarGod")?.querySelectorAll("ul li a")?.forEach(link => {
    if (opcionesRol.includes(link)) {
        link.style.display = 'block';
    } else {
        link.style.display = 'none';
    }
})