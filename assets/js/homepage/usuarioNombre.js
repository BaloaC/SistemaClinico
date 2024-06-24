import Cookies from "../../libs/jscookie/js.cookie.min.js";


const nombreUsuarioInput = document.getElementById("usuarioNombre");
const nombreUsuario = Cookies.get("usuario");
const rolUsuario = Cookies.get("rol");



let nombreDelRol;

switch(rolUsuario) {
    case "1": nombreDelRol = "Administrador"; break;
    case "2": nombreDelRol = "Gerente"; break;
    case "3": nombreDelRol = "Analista"; break;
    case "4": nombreDelRol = "Contador"; break;
    case "5": nombreDelRol = "Facultativo de Salud"; break;
}

nombreUsuarioInput.textContent = `${nombreUsuario} - ${nombreDelRol}`;