import scrollTo from "./scrollTo.js";

export default function showDefaultModalAct({ form, successMessage, actAlert = "actAlert", modal = "#modalAct" }) {

    const alert = document.getElementById(actAlert);
    alert.classList.remove("alert-danger");
    alert.classList.add("alert-success");
    alert.classList.remove("d-none");
    alert.textContent = successMessage;
    form.reset();

    scrollTo("modalActBody");

    setTimeout(() => {
        $(modal).modal("hide");
        alert.classList.add("d-none");
    }, 500);

}