import getAge from "../global/getAge.js";

const disabledInputs = document.querySelectorAll(".form-control[disabled]");

export function tipoPacienteChange(e) {

    const subMenus = document.querySelector(".sub-menus");
    const modalRegContent = document.getElementById("modalRegBody");
    let counter = 1,
        selectedSubMenu = e.target.value;

    for (const subMenu of subMenus.children) {

        const subMenuInputs = subMenu.querySelectorAll("input, select");

        // Si se agrego primero la fecha y luego cambia el select, mostrar si desea añadir la cedula en el caso sea seleccionado el paciente
        if ((selectedSubMenu == 4 && counter == 1)) {

            let fechaNacimiento = document.getElementById("fecha_nacimiento").value.split("-");
            let edad = getAge(fechaNacimiento[0], fechaNacimiento[1], fechaNacimiento[2]);

            const cedulaInput = document.getElementById("cedula");
            const telefonoInput = document.getElementById("telefono");
            const codTelInput = document.getElementById("cod-tel");
            const cedulaMenorLabel = document.querySelector("label[for='pacienteMenorLabel']");
            const cedulaMenorContainer = document.querySelector(".pacienteMenorContainer");
            const cedulaMenorSi = document.getElementById("cedula_menor_si");
            const cedulaMenorNo = document.getElementById("cedula_menor_no");

            if (edad < 18) {

                // Validamos que si el paciente es mayor de 9 de años se permita eligir si posee cédula, caso contrario ocultamos los inputs radio
                if (edad >= 9) {

                    cedulaMenorLabel.classList.remove("opacity-0");
                    setTimeout(() => {
                        cedulaMenorLabel.classList.remove("d-none");
                    }, 550);

                    cedulaMenorContainer.classList.remove("opacity-0");
                    setTimeout(() => {
                        cedulaMenorContainer.classList.remove("d-none");
                    }, 550);
                } else {
                    cedulaMenorLabel.classList.add("opacity-0");
                    setTimeout(() => {
                        cedulaMenorLabel.classList.add("d-none");
                    }, 550);

                    cedulaMenorContainer.classList.add("opacity-0");
                    setTimeout(() => {
                        cedulaMenorContainer.classList.add("d-none");
                    }, 550);
                }

                cedulaInput.disabled = true;
                telefonoInput.disabled = true;
                codTelInput.disabled = true;
                cedulaMenorNo.checked = true;
                cedulaMenorNo.disabled = false;

            } else {


                cedulaMenorLabel.classList.add("opacity-0");
                setTimeout(() => {
                    cedulaMenorLabel.classList.add("d-none");
                }, 550);

                cedulaMenorContainer.classList.add("opacity-0");
                setTimeout(() => {
                    cedulaMenorContainer.classList.add("d-none");
                }, 550);

                cedulaInput.disabled = false;
                telefonoInput.disabled = false;
                codTelInput.disabled = false;
                cedulaMenorNo.checked = true;
                cedulaMenorNo.disabled = true;
            }

        }

        if ((selectedSubMenu == 3 && counter == 2) || (selectedSubMenu == 4 && counter == 1)) {

            subMenuInputs.forEach(el => {
                el.disabled = false;
            });

            subMenu.classList.remove("opacity-0");
            setTimeout(() => {
                subMenu.classList.remove("d-none");

                // Bajar el scroll hacia abajo luego de mostrar todo el contenido
                modalRegContent.scrollTo({
                    top: modalRegContent.scrollHeight,
                    bottom: 0,
                    behavior: 'smooth'
                });
            }, 550);

        } else {

            const cedulaMenorLabel = document.querySelector("label[for='pacienteMenorLabel']");
            const cedulaMenorContainer = document.querySelector(".pacienteMenorContainer");

            subMenuInputs.forEach(el => {
                el.disabled = true;
            })

            setTimeout(() => {
                subMenu.classList.add("d-none");
            }, 550);

            if(selectedSubMenu === "") {
                cedulaMenorContainer.classList.add("d-none");
                cedulaMenorLabel.classList.add("d-none");
            }
        }

        const selectTitular = document.getElementById("s-titular_id");
        if (selectTitular.value === "") document.getElementById("s-titular_id").disabled = true;
        counter++;
    }
}


document.getElementById("s-tipo_paciente").addEventListener("change", event => tipoPacienteChange(event))
