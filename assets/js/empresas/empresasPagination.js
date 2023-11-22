import concatItems from "../global/concatItems.js";
import getAll from "../global/getAll.js";

const listadoEmpresas = await getAll("empresas/consulta");
const registros = listadoEmpresas != typeof Array ? listadoEmpresas : undefined;

// Configurar la paginación
const registrosPorPagina = 15;
let paginaActual = 1;


export function empresasPagination(registros) {

    if (registros == undefined) {
        const mensajeVacio = `<p class="text-center mb-5 fs-5">No se encontraron registros.</p>`
        document.getElementById('card-container').innerHTML = mensajeVacio;
        document.getElementById('boton-pagina-siguiente').classList.add("d-none");
        document.getElementById('boton-pagina-anterior').classList.add("d-none");
        return;
    } else {

        document.getElementById('boton-pagina-siguiente').classList.remove("d-none");
        document.getElementById('boton-pagina-anterior').classList.remove("d-none");

        function crearTarjeta(registro, plantilla, separadores = {}) {
            // Crear el elemento de la tarjeta
            const tarjeta = document.createElement('div');
            tarjeta.classList.add('card-container', 'col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
            tarjeta.setAttribute("onclick", `getEmpresa(${registro.empresa_id})`);
            tarjeta.setAttribute("data-bs-toggle", "modal");
            tarjeta.setAttribute("data-bs-target", "#modalInfo");

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
            document.getElementById('card-container').appendChild(tarjeta);
        }

        const plantilla = `
            <div class="card overflow-hidden">
              <div class="overlay-box">
                <h3 class="mt-3 mb-0 text-white">\${nombre}</h3>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><span class="mb-0">Rif</span> <b class="text-muted">\${rif}</b></li>
                <li class="list-group-item"><span class="mb-0">Seguro</span> <b class="text-muted">\${seguro}</b></li>
              </ul>
            </div>
          `;

        // Objeto con los nombres de las propiedades y los separadores para la función `concatItems()`
        const separadores = {
            seguro: {
                propiedad: 'nombre',
                mensajeVacio: 'No posee ningún seguro'
            }
        };

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

        function seleccionarPrimerBoton() {
            const primerBoton = document.querySelector('.btn.page-item.page-link');
            if (primerBoton) {
                primerBoton.click();
            }
        }

        // Mostrar los registros de la página actual
        mostrarRegistros();
        crearBotones();

        // Seleccionar por defecto el primer botón
        seleccionarPrimerBoton();

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

empresasPagination(registros);
