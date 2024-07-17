import Cookies from "../../libs/jscookie/js.cookie.min.js";

const rol = Cookies.get("rol");
const adminModule = document.querySelector(".admin-module");
const personalModule = document.querySelector(".personal-module");
const atencionModule = document.querySelector(".atencion-module");
const atencionModule2 = document.querySelector(".atencion-module2");
const facturacionModule = document.querySelector(".facturacion-module");
const inventarioModule = document.querySelector(".inventario-module");
const insumosSection = document.querySelector(".insumosSection");
const pdfLink = document.getElementById("pdfLink");

const deleteOffsetMargin = () => {
    const offsetContainer = document.querySelectorAll(".offset-lg-2");
    offsetContainer.forEach(element => element.classList.remove("offset-lg-2"));
}

if (rol === "2") {
    adminModule.classList.add("d-none");
    atencionModule.classList.add("d-none");
    atencionModule2.classList.remove("d-none");
    pdfLink.href = "./assets/manuales/gerente.pdf";
    deleteOffsetMargin();
    // personalModule.classList.add("ms-5");
    atencionModule2.classList.add("ms-5");
    // facturacionModule.classList.add("ms-5");
    inventarioModule.classList.add("ms-5");
}

if (rol === "3") {
    adminModule.classList.add("d-none");
    personalModule.classList.add("d-none");
    atencionModule.classList.add("d-none");
    pdfLink.href = "./assets/manuales/contador.pdf";
    deleteOffsetMargin();
    facturacionModule.style = "min-width: 400px";
    inventarioModule.style = "min-width: 400px";
    insumosSection.style = "display: none";
}

if (rol === "4") {
    adminModule.classList.add("d-none");
    personalModule.classList.add("d-none");
    facturacionModule.classList.add("d-none");
    inventarioModule.classList.add("d-none");
    document.querySelector(".consulta-link").classList.add("d-none");
    document.querySelector(".examen-link").classList.add("d-none");
    atencionModule.classList.add("w-50");
    pdfLink.href = "./assets/manuales/analista.pdf";
    deleteOffsetMargin();
}

if (rol === "5") {
    adminModule.classList.add("d-none");
    personalModule.classList.add("d-none");
    facturacionModule.classList.add("d-none");
    inventarioModule.classList.add("d-none");
    atencionModule.classList.add("w-50");
    pdfLink.href = "./assets/manuales/salud.pdf";
    insumosSection.style = "display: none";
    deleteOffsetMargin()
}