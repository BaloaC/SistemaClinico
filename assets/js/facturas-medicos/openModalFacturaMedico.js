import formatToRealDate from "../global/formatToRealDate.js";
import getById from "../global/getById.js";

async function openModalFacturaMedico(id) {
    if (id) {

        $("#modalAcumulado").modal("show");

        const facturaMensajeria = await getById("factura/consultas/", id);
        const listConsultas = facturaMensajeria;
        const consultaContainer = document.getElementById("consultaAccordion");
        const templateConsulta = document.getElementById("template-consulta").content;
        const consultaFragment = document.createDocumentFragment();

        if (listConsultas.length > 0) {

            $(".loadingMessage").fadeOut("slow");
            $(".consultaLabel").fadeIn("slow");

            listConsultas.forEach((el, i) => {
                console.log("🍓 ~ file: detalleFacturas.js:32 ~ listConsultas.forEach ~ el:", el)

                let dropdownLink = templateConsulta.querySelector(".btn-link");
                let consultaContainer = templateConsulta.querySelector(".collapse");
                let consulta_id = templateConsulta.getElementById("consulta_id");
                let nombre_medico = templateConsulta.getElementById("nombre_medico");
                let especialidad = templateConsulta.getElementById("especialidad");
                let fecha_consulta = templateConsulta.getElementById("fecha_consulta");
                let motivo_cita = templateConsulta.getElementById("motivo_cita");
                let indicaciones = templateConsulta.getElementById("indicaciones");
                let observaciones = templateConsulta.getElementById("observaciones");
                let montoTotalUsd = templateConsulta.getElementById("monto_total_usd");
                let montoTotalBs = templateConsulta.getElementById("monto_total_bs");

                if (i === 0) {
                    consultaContainer.classList.add("show");
                } else {
                    consultaContainer.classList.remove("show");
                }

                consulta_id.textContent = el.consulta_id;
                nombre_medico.textContent = `${el.nombre_medico ?? el?.medico?.nombre ?? "Consulta por emergencia"} ${el.apellidos_medico ?? el?.medico?.apellidos_medico ?? el?.medico?.apellidos ?? ""}`;
                especialidad.textContent = el.nombre_especialidad ?? el?.medico?.nombre_especialidad ?? el?.especialidad?.nombre;
                fecha_consulta.textContent = formatToRealDate(el?.fecha_consulta ?? el?.consulta.fecha_consulta);
                observaciones.textContent = el?.consulta?.observaciones || "Sin observaciones";
                motivo_cita.textContent = el.motivo_cita ?? el?.cita?.motivo_cita ?? "La consulta es de emergencia";
                indicaciones.textContent = el.indicaciones !== undefined ? concatItems(el.indicaciones, "descripcion", "No se realizó ninguna indicación", ".") : "No se realizó ninguna indicación";
                // montoTotalUsd.textContent = `$${el.monto_total_usd}`;
                // montoTotalBs.textContent = `${el.monto_total_bs} Bs`;

                dropdownLink.innerHTML = `<b>Especialidad:</b> ${especialidad.textContent} <br> <b>Fecha:</b> ${fecha_consulta.textContent}`;
                dropdownLink.setAttribute("data-bs-target", `#consulta-${el.consulta_id}`);
                dropdownLink.setAttribute("aria-controls", `#consulta-${el.consulta_id}`);
                consultaContainer.setAttribute("id", `consulta-${el.consulta_id}`);

                let clone = document.importNode(templateConsulta, true);
                consultaFragment.appendChild(clone);
            });

            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(consultaFragment);

        } else {

            const h3 = document.createElement("h3");
            h3.textContent = "El paciente no posee consultas";

            // Actualizamos el contenedor e insertamos los datos
            consultaContainer.replaceChildren();
            consultaContainer.appendChild(h3);

            $(".loadingMessage").fadeOut("slow");
        }
    }
}

window.openModalFacturaMedico = openModalFacturaMedico;