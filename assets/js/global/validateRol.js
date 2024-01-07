import Cookies from "../../libs/jscookie/js.cookie.min.js";

export function removeAddAnalist() {
    if (Cookies.get("rol") == 4) {
        document.getElementById('btn-add').classList.add('d-none');
    }
}

export function removeAddAccountant () {
    if (Cookies.get("rol") == 3) {
        document.getElementById('btn-add').classList.add('d-none');
    }
}

export function removeAddMD() {
    if (Cookies.get("rol") == 5) {
        document.getElementById('btn-add').classList.add('d-none');
    }
}