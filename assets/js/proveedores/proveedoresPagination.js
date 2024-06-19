import concatItems from "../global/concatItems.js";
import getAll from "../global/getAll.js";

let draw = 1;
let start = 0;
let timestamp = new Date().getTime();

// Configurar la paginación
const registrosPorPagina = 15;
export let pagination = { initializated: false, paginaActual: 1 };

const listadoProveedores = await getAll(`proveedores/consulta?draw=1&start=0&length=${registrosPorPagina}&search%5Bvalue%5D&search%5Bregex%5D=false&_=${timestamp}`, false);

export const listadoProveedoresPagination = { registros: listadoProveedores.data }
export const buscarRegistrosObj = { valor: document.getElementById("inputSearch").value };

let registrosProv = listadoProveedoresPagination.registros != typeof Array ? { data: listadoProveedoresPagination.registros } : undefined;
registrosProv.recordsTotal = listadoProveedores?.recordsTotal;
registrosProv.draw = listadoProveedores?.draw;

// Función para hacer las petición por SSR
export async function ssrProveedoresRequest(numPage, search = "") {

    draw++;
    start = (numPage - 1) * registrosPorPagina;
    const fetchRequest = await getAll(`proveedores/consulta?draw=${draw}&start=${start}&length=${registrosPorPagina}&search%5Bvalue%5D${search}&search%5Bregex%5D=false&_=${timestamp}`, false);

    return fetchRequest;
}

export async function proveedoresPagination(registros, buscarRegistros = "") {

    if (registros?.length <= 0 || registros === undefined || registros?.data === undefined || registros?.data.length === 0) {

        const mensajeVacio = `<p class="text-center mb-5 fs-5">No se encontraron registros.</p>`
        document.getElementById('card-container').innerHTML = mensajeVacio;
        document.getElementById('boton-pagina-siguiente').classList.add("d-none");
        document.getElementById('boton-pagina-anterior').classList.add("d-none");
        return;
    } else {

        registrosProv = registros;

        document.getElementById('boton-pagina-siguiente').classList.remove("d-none");
        document.getElementById('boton-pagina-anterior').classList.remove("d-none");

        function crearTarjeta(registro, plantilla, separadores = {}) {
            // Crear el elemento de la tarjeta
            const tarjeta = document.createElement('div');
            tarjeta.classList.add('card-container', 'col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12', 'd-flex');

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
            <div class="card overflow-hidden align-cards">
            <div class="overlay-box">
                <h3 class="text-white">\${nombre}</h3>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span class="mb-0">Ubicación</span> <b class="text-muted">\${ubicacion}</b></li>
                <li class="list-group-item"><span class="mb-0"><button type="button" id="btn-actualizar" class="btn btn-primary" onclick="updateProveedor(\${proveedor_id})" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar</button></span><button id="btn-eliminar" class="btn btn-danger" onclick="deleteProveedor(\${proveedor_id})"  data-bs-toggle="modal" data-bs-target="#modalDelete">Eliminar</button></li>
            </ul>
            </div>
        `;

        // Objeto con los nombres de las propiedades y los separadores para la función `concatItems()`
        const separadores = {};

        // Función para mostrar los registros de la página actual
        function mostrarRegistros(list) {
            // Obtener el número de registros a mostrar
            const inicio = (pagination.paginaActual - 1) * registrosPorPagina;
            const fin = inicio + registrosPorPagina;

            // Limpiar el contenedor de tarjetas
            document.getElementById('card-container').innerHTML = '';

            // Mostrar los registros de la página actual
            for (let i = 0; i < fin && i < list?.data?.length; i++) {
                crearTarjeta(list.data[i], plantilla, separadores);
            }

            // Actualizar los botones de paginación
            actualizarBotonesPaginacion();
        }

        function crearBotones() {
            // Calcular el número de páginas
            const numPaginas = Math.ceil(registrosProv.recordsTotal / registrosPorPagina);

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
                if (pagination.paginaActual < 4) {
                    fin = 6;
                } else if (pagination.paginaActual > numPaginas - 3) {
                    inicio = numPaginas - 6;
                } else {
                    inicio = pagination.paginaActual - 4;
                    fin = pagination.paginaActual + 3;
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
            botonPagina.addEventListener('click', async () => {
                pagination.paginaActual = numeroPagina;
                mostrarRegistros(await ssrProveedoresRequest(pagination.paginaActual, `=${document.getElementById("inputSearch").value}`));
            });

            // Resaltar el botón de página actual
            if (numeroPagina === pagination.paginaActual) {
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
            if (pagination.paginaActual === 1) {
                botonPaginaAnterior.setAttribute('disabled', 'disabled');
            } else {
                botonPaginaAnterior.removeAttribute('disabled');
            }

            // Actualizar el botón de página siguiente
            if (pagination.paginaActual === Math.ceil(registrosProv.recordsTotal / registrosPorPagina)) {
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
                pagination.paginaActual = 1;
            }
        }

        // Mostrar los registros de la página actual
        mostrarRegistros(registrosProv, buscarRegistros);
        crearBotones();

        // Seleccinamos el primer botón para asegurarnos que siempre sea la primera pagina cuando se ejecuten acciones
        if (pagination.initializated === true) seleccionarPrimerBoton()

        async function botonAnteriorAction() {
            pagination.paginaActual--;
            mostrarRegistros(await ssrProveedoresRequest(pagination.paginaActual, `=${document.getElementById("inputSearch").value}`));
        }

        async function botonSiguienteAction() {
            pagination.paginaActual++;
            mostrarRegistros(await ssrProveedoresRequest(pagination.paginaActual, `=${document.getElementById("inputSearch").value}`));
        }

        if (pagination.initializated === false) {

            // Agregar el evento de clic al botón de página anterior
            const botonPaginaAnterior = document.getElementById('boton-pagina-anterior');
            const botonPaginaSiguiente = document.getElementById('boton-pagina-siguiente');

            // Agregar el evento de clic al botón de página anterior
            botonPaginaAnterior.addEventListener('click', () => {
                botonAnteriorAction();
            });

            // Agregar el evento de clic al botón de página siguiente    
            botonPaginaSiguiente.addEventListener('click', () => {
                botonSiguienteAction();
            });

            // Agregar el evento de cambio de tamaño de ventana
            window.addEventListener('resize', () => {
                // Actualizar los botones de paginación
                actualizarBotonesPaginacion();
            });

            pagination.initializated = true;
        }
    }
}

proveedoresPagination(registrosProv, buscarRegistrosObj.valor);

