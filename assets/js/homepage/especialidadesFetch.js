import getAll from "../global/getAll.js";
async function getEspecialidades() {

    const especialidades = await getAll("especialidades/consulta");
    const especialidadesDropdown = document.getElementById("especialidadDropdown");

    for (let i = 0; i < especialidades.length; i++) {

        // Validamos que sea cada tercer elemento
        if (i % 3 === 0) {

            let cadena = especialidades[i]["nombre"]; // Iniciar la cadena con el primer elemento del grupo de tres

            if (especialidades[i + 1]["nombre"] !== undefined) {
                cadena += " - " + especialidades[i + 1]["nombre"];
            }

            if (especialidades[i + 2]["nombre"] !== undefined) {
                cadena += " - " + especialidades[i + 2]["nombre"];
            }


            let nuevoParrafo = document.createElement("p");
            nuevoParrafo.textContent = cadena;
            nuevoParrafo.classList.add("dropdown-item");
            especialidadesDropdown.appendChild(nuevoParrafo);
        }
    }

}
await getEspecialidades();