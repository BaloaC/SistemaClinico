import Cookies from "../../libs/jscookie/js.cookie.min.js";

const rol = Cookies.get("rol");
const adminModule = document.querySelector(".admin-module");
const personalModule = document.querySelector(".personal-module");
const atencionModule = document.querySelector(".atencion-module");
const facturacionModule = document.querySelector(".facturacion-module");
const inventarioModule = document.querySelector(".inventario-module");
const pdfLink = document.getElementById("pdfLink");

const deleteOffsetMargin = () => {
    const offsetContainer = document.querySelectorAll(".offset-lg-2");
    offsetContainer.forEach(element => element.classList.remove("offset-lg-2"));
}

if (rol === "2") {
    adminModule.classList.add("d-none");
    pdfLink.href = "./assets/manuales/gerente.pdf";
    deleteOffsetMargin();
}

if (rol === "3") {
    adminModule.classList.add("d-none");
    personalModule.classList.add("d-none");
    atencionModule.classList.add("d-none");
    pdfLink.href = "./assets/manuales/contador.pdf";
    deleteOffsetMargin();
}

if(rol === "4") {
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

if(rol === "5") {
    adminModule.classList.add("d-none");
    personalModule.classList.add("d-none");
    facturacionModule.classList.add("d-none");
    inventarioModule.classList.add("d-none");
    atencionModule.classList.add("w-50");
    pdfLink.href = "./assets/manuales/salud.pdf";
    deleteOffsetMargin()
}