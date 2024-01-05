import concatItems from "../global/concatItems.js";
import getAll from "../global/getAll.js";
import { removeAddAccountant, removeAddAnalist, removeAddMD } from "../global/validateRol.js";

const listadoFacturas = await getAll("factura/seguro/consulta");

/* 
    Obtenemos los años a mostrar de acuerdo a las fechas registrados
    PD: El filter lo añadí por si existe algún registro sin fecha ocurrencia, no marque error
*/

const listaSegurosPorAge = listadoFacturas.reduce((lista, factura) => {
    const año = factura.fecha_ocurrencia.slice(0, 4);
    const seguro = { seguro_id: factura.seguro_id, nombre: factura.nombre };
    const elemento = lista.find(item => item.age === año);
    if (elemento) {
        if (!elemento.seguros_id.find(s => s.seguro_id === seguro.seguro_id)) {
            elemento.seguros_id.push(seguro);
        }
    } else {
        lista.push({ age: año, seguros_id: [seguro] });
    }
    return lista;
}, []);


// const uniqueAges = [...new Set(listadoFacturas.filter(factura => factura.fecha_ocurrencia).map(factura => factura.fecha_ocurrencia.slice(0, 4)))].sort((a, b) => b - a);

const registros = listaSegurosPorAge != typeof Array ? listaSegurosPorAge : undefined;

removeAddAccountant();
removeAddAnalist();
removeAddMD();
// Configurar la paginación
const registrosPorPagina = 15;
let paginaActual = 1;


export function examenesPagination(registros) {

    if (registros?.length === 0 || registros === undefined) {
        const mensajeVacio = `<p class="text-center mb-5 fs-5">No se encontraron registros.</p>`
        document.getElementById('card-container').innerHTML = mensajeVacio;
        document.getElementById('boton-pagina-siguiente').classList.add("d-none");
        document.getElementById('boton-pagina-anterior').classList.add("d-none");
        return;
    } else {

        function crearTarjeta(registro, plantilla, separadores = {}) {
            // Crear el elemento de la tarjeta
            const tarjeta = document.createElement('div');
            tarjeta.classList.add('card-container', 'col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');

            const dropdownInfo = document.createElement("div");
            dropdownInfo.classList.add("dropdown-menu");
            dropdownInfo.setAttribute("arial-labelledby", "navbarDropdown");
            dropdownInfo.setAttribute("id", `${registro.age}`);

            const dropdownLinkFragment = document.createDocumentFragment();

            if (registro.seguros_id.length > 0) {

                // Crear un contenedor con la clase "row" para los elementos del dropdown
                let dropdownRow = document.createElement("div");
                dropdownRow.classList.add("row");

                // Crear un contador para llevar el seguimiento de los enlaces del dropdown
                let dropdownCounter = 0;

                registro.seguros_id.forEach(el => {

                    // Incrementar el contador para el enlace actual
                    dropdownCounter++;

                    // Crear un div con la clase col para que se ajuste
                    const divCol = document.createElement("div");
                    divCol.classList.add("col");

                    const link = document.createElement("a");
                    link.classList.add("dropdown-item");
                    link.href = `seguros/${el.seguro_id}-${registro.age}`;
                    link.id = el.seguro_id;

                    const seguro = document.createElement("div");
                    seguro.classList.add("seguro-dropdown-link");

                    const img = document.createElement("img");
                    img.src = "https://cdn-icons-png.flaticon.com/64/4434/4434431.png";

                    const p = document.createElement("p");
                    p.textContent = el.nombre;

                    seguro.appendChild(img);
                    seguro.appendChild(p);
                    link.appendChild(seguro);
                    divCol.appendChild(link);

                    // Agregar el enlace al contenedor de la fila del dropdown
                    dropdownRow.appendChild(divCol);

                    // Verificar si se han agregado tres enlaces
                    if (dropdownCounter === 3) {
                        // Agregar la fila actual al dropdown
                        dropdownLinkFragment.appendChild(dropdownRow);

                        dropdownRow = document.createElement("div");
                        dropdownRow.classList.add("row");

                        // Reiniciar el contador de enlaces
                        dropdownCounter = 0;
                    }

                });

                // Verificar si queda una fila incompleta
                if (dropdownCounter > 0) {
                    // Agregar la fila actual al dropdown
                    dropdownLinkFragment.appendChild(dropdownRow);
                }

                dropdownInfo.appendChild(dropdownLinkFragment);
            }

            // Agregar el contenido a la tarjeta
            tarjeta.innerHTML = plantilla.replace(/\${(.*?)}/g, (match, p1) => {

                // Validamos si se envía un separador o la propiedad es un array
                if (separadores[p1] || Array.isArray(registro[p1])) {
                    return concatItems(registro[p1], separadores[p1].propiedad, separadores[p1].mensajeVacio);
                } else {
                    return registro[p1];
                }
            });

            // Agregar la tarjeta al contenedor
            tarjeta.appendChild(dropdownInfo);
            document.getElementById('card-container').appendChild(tarjeta);
        }

        const plantilla = `
        <div class="card overflow-hidden dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="overlay-box">
            <h3 class="mt-3 mb-0 text-white">\${age}</h3>
          </div>
        </div>
        
      `;

        // Objeto con los nombres de las propiedades y los separadores para la función `concatItems()`
        const separadores = {};

        // Función para mostrar los registros de la página actual
        function mostrarRegistros() {
            // Obtener el número de registros a mostrar
            const inicio = (paginaActual - 1) * registrosPorPagina;
            const fin = inicio + registrosPorPagina;

            // Limpiar el contenedor de tarjetas
            document.getElementById('card-container').innerHTML = '';

            // Mostrar los registros de la página actual
            for (let i = inicio; i < fin && i < registros.length; i++) {
                crearTarjeta(registros[i], plantilla, separadores);
            }

            // Actualizar los botones de paginación
            actualizarBotonesPaginacion();
        }

        function crearBotones() {
            // Calcular el número de páginas
            const numPaginas = Math.ceil(registros.length / registrosPorPagina);

            // Limpiar el contenedor de paginación
            document.getElementById('pagination-container').innerHTML = '';

            // Crear los botones de página
            const botonesPagina = [];
            for (let i = 1; i <= numPaginas; i++) {
                botonesPagina.push(crearBotonPagina(i));
            }

            // Limitar el número de botones a mostrar
            let inicio = 0;
            let fin = numPaginas;
            if (numPaginas > 6) {
                if (paginaActual < 4) {
                    fin = 6;
                } else if (paginaActual > numPaginas - 3) {
                    inicio = numPaginas - 6;
                } else {
                    inicio = paginaActual - 4;
                    fin = paginaActual + 3;
                }

                // Agregar el botón de primera página si no se muestra
                if (inicio > 0) {
                    const botonPrimeraPagina = crearBotonPagina(1);
                    document.getElementById('pagination-container').appendChild(botonPrimeraPagina);
                    const separador = document.createElement('span');
                    separador.innerText = '...';
                    document.getElementById('pagination-container').appendChild(separador);
                }

                // Agregar los botones de página
                for (let i = inicio; i < fin; i++) {
                    document.getElementById('pagination-container').appendChild(botonesPagina[i]);
                }

                // Agregar el botón de última página si no se muestra
                if (fin < numPaginas) {
                    const separador = document.createElement('span');
                    separador.innerText = '...';
                    document.getElementById('pagination-container').appendChild(separador);
                    const botonUltimaPagina = crearBotonPagina(numPaginas);
                    document.getElementById('pagination-container').appendChild(botonUltimaPagina);
                }
            } else {
                // Agregar todos los botones de página
                for (let i = 0; i < botonesPagina.length; i++) {
                    document.getElementById('pagination-container').appendChild(botonesPagina[i]);
                }
            }
        }

        // Función para crear un botón de página
        function crearBotonPagina(numeroPagina) {
            // Crear el botón de página
            const botonPagina = document.createElement('button');
            botonPagina.classList.add('btn', 'page-item', 'page-link');
            botonPagina.innerText = numeroPagina;

            // Agregar el evento de clic al botón de página
            botonPagina.addEventListener('click', () => {
                paginaActual = numeroPagina;
                mostrarRegistros();
            });

            // Resaltar el botón de página actual
            if (numeroPagina === paginaActual) {
                botonPagina.classList.add('active');
            }

            // Devolver el botón de página
            return botonPagina;
        }

        function actualizarBotonesPaginacion() {
            // Verificar si los botones de página anterior y siguiente existen en la página
            const botonPaginaAnterior = document.getElementById('boton-pagina-anterior');
            const botonPaginaSiguiente = document.getElementById('boton-pagina-siguiente');
            if (!botonPaginaAnterior || !botonPaginaSiguiente) {
                return;
            }

            // Actualizar el botón de página anterior
            if (paginaActual === 1) {
                botonPaginaAnterior.setAttribute('disabled', 'disabled');
            } else {
                botonPaginaAnterior.removeAttribute('disabled');
            }

            // Actualizar el botón de página siguiente
            if (paginaActual === Math.ceil(registros.length / registrosPorPagina)) {
                botonPaginaSiguiente.setAttribute('disabled', 'disabled');
            } else {
                botonPaginaSiguiente.removeAttribute('disabled');
            }

            // Actualizar los botones de página
            crearBotones();
        }

        // Agregar el evento de carga de la página

        // Mostrar los registros de la página actual
        mostrarRegistros();
        crearBotones();

        // Agregar el evento de clic al botón de página anterior
        const botonPaginaAnterior = document.getElementById('boton-pagina-anterior');
        if (botonPaginaAnterior) {
            botonPaginaAnterior.addEventListener('click', () => {
                paginaActual--;
                mostrarRegistros();
            });
        }

        // Agregar el evento de clic al botón de página siguiente
        const botonPaginaSiguiente = document.getElementById('boton-pagina-siguiente');
        if (botonPaginaSiguiente) {
            botonPaginaSiguiente.addEventListener('click', () => {
                paginaActual++;
                mostrarRegistros();
            });
        }

        // Agregar el evento de cambio de tamaño de ventana
        window.addEventListener('resize', () => {
            // Actualizar los botones de paginación
            actualizarBotonesPaginacion();
        });
    }
}

examenesPagination(registros);