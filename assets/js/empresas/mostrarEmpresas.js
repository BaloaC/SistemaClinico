import concatItems from "../global/concatItems.js";
import { select2OnClick } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import getById from "../global/getById.js";


const listadoEmpresas = await getAll("empresas/consulta");
// console.log(listadoEmpresas);
const registros = listadoEmpresas;
console.log(registros);
//     $cardTemplate = document.getElementById("card-template").content,
//     $empresasContainer = document.getElementById("empresas-container"),
//     $fragment = document.createDocumentFragment();


// Obtener los datos de los registros de alguna manera (por ejemplo, de una API)
// const registros = [
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
//     { nombre: 'Empresa 1', rif: 'J-1111111', seguro: 'Seguro A' },
//     { nombre: 'Empresa 2', rif: 'J-2222222', seguro: 'Seguro B' },
//     { nombre: 'Empresa 3', rif: 'J-3333333', seguro: 'Seguro C' },
//     { nombre: 'Empresa 4', rif: 'J-4444444', seguro: 'Seguro D' },
//     { nombre: 'Empresa 5', rif: 'J-5555555', seguro: 'Seguro E' },
//     { nombre: 'Empresa 6', rif: 'J-6666666', seguro: 'Seguro F' },
//     { nombre: 'Empresa 7', rif: 'J-7777777', seguro: 'Seguro G' },
//     { nombre: 'Empresa 8', rif: 'J-8888888', seguro: 'Seguro H' },
//     { nombre: 'Empresa 9', rif: 'J-9999999', seguro: 'Seguro I' },
//     { nombre: 'Empresa 10', rif: 'J-10101010', seguro: 'Seguro J' },
//     { nombre: 'Empresa 11', rif: 'J-11111111', seguro: 'Seguro K' },
//     { nombre: 'Empresa 12', rif: 'J-12121212', seguro: 'Seguro L' },
// ];

// Configurar la paginación
const registrosPorPagina = 6;
let paginaActual = 1;


function crearTarjeta(registro, plantilla, separadores = {}) {
    // Crear el elemento de la tarjeta
    const tarjeta = document.createElement('div');
    tarjeta.classList.add('card-container', 'col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
    tarjeta.setAttribute("onclick", `getEmpresa(${registro.empresa_id})`);
    tarjeta.setAttribute("data-bs-toggle","modal");
    tarjeta.setAttribute("data-bs-target","#modalInfo");

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




async function getEmpresa(id) {
    try {

        const $nombreEmpresa = document.getElementById("nombreEmpresa"),
            $rifEmpresa = document.getElementById("rifEmpresa"),
            $nombreSeguro = document.getElementById("nombreSeguro"),
            $direcEmpresa = document.getElementById("direcEmpresa"),
            $btnActualizar = document.getElementById("btn-actualizar"),
            $btnEliminar = document.getElementById("btn-confirmDelete");

        const json = await getById("empresas/", id);

        $nombreEmpresa.innerText = `${json.nombre}`;
        $rifEmpresa.innerText = `${json.rif}`;
        $direcEmpresa.innerText = `${json.direccion}`;
        // $nombreSeguro.innerText = `${json[0].nombre}`;
        $btnActualizar.setAttribute("onclick", `updateEmpresa(${id})`);
        $btnEliminar.setAttribute("onclick", `deleteEmpresa(${id})`);

    } catch (error) {

        alert(error);
    }
}

window.getEmpresa = getEmpresa;


export function mostrarEmpresas(listadoEmpresas) {

    try {


        // // ! 0 = para empresas sin seguro afiliado, 1 = seguros afiliados empresas
        // listadoEmpresas.forEach(el => {

        //     if(!el.seguro) return;

        //     let $nombreEmpresa = $cardTemplate.querySelector("h3"),
        //         $cardContainer = $cardTemplate.querySelector(".card-container"),
        //         $rif = $cardTemplate.querySelector(".list-group > li:nth-child(1) > b"),
        //         $nombreSeguro = $cardTemplate.querySelector(".list-group > li:nth-child(2) > b");

        //     $nombreEmpresa.textContent = el.nombre;
        //     $rif.textContent = el.rif;
        //     $nombreSeguro.textContent = concatItems(el.seguro, "nombre", "No posee ningún seguro")
        //     $cardContainer.setAttribute("onclick", `getEmpresa(${el.empresa_id})`);

        //     let clone = document.importNode($cardTemplate, true);
        //     $fragment.appendChild(clone);
        // })

        // $empresasContainer.replaceChildren();
        // $empresasContainer.appendChild($fragment);

    } catch (error) {
        console.log(error);
    }
}

// document.addEventListener("DOMContentLoaded", async () => {


// })

// addEventListener("DOMContentLoaded", );

select2OnClick({
    selectSelector: "#s-seguro",
    selectValue: "seguro_id",
    selectNames: ["rif", "nombre"],
    module: "seguros/consulta",
    parentModal: "#modalReg",
    placeholder: "Seleccione un seguro",
    selectWidth: "100%"
});