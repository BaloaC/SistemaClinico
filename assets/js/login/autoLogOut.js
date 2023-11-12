import Cookies from "../../libs/jscookie/js.cookie.min.js";

function autoLogOut() {

    Cookies.remove("tokken");
    Cookies.remove("usuario");
    Cookies.remove("usuario_id");
    Cookies.remove("rol");
}

window.addEventListener("pageshow", () => {
    autoLogOut();
});