import Cookies from "../../libs/jscookie/js.cookie.min.js";

export function removeAddAnalist() {
    if (Cookies.get("rol") == 4) {
        document.getElementById('btn-add')?.classList.add('d-none');
    }
}

export function removeAddAccountant () {
    if (Cookies.get("rol") == 3) {
        document.getElementById('btn-add')?.classList.add('d-none');
    }
}

export function removeAddMD() {
    if (Cookies.get("rol") == 5) {
        document.getElementById('btn-add')?.classList.add('d-none');
    }
}

export function removeDeleteAnalist() {
    if (Cookies.get("rol") == 4) {
        document.getElementById('btn-delete')?.classList.add('d-none');
    }
}

export function removeActAnalist() {
    if (Cookies.get("rol") == 4) {
        document.getElementById('btn-actualizar').removeAttribute("data-bs-target");
        document.getElementById('btn-actualizar')?.classList.remove("cursor-pointer");
        document.querySelector('.resumen-mensual')?.classList.add("d-none");
    }
}