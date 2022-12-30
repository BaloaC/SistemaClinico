import * as validation from "./validarServicio.js";

// Script para los botones de "proximo paso y las tabs"
let tabPaso1 = document.getElementById('nav-item-info-tab');
let tabPaso2 = document.getElementById('nav-item-details-tab');
let tabPaso3 = document.getElementById('nav-user-info-tab');

let tabStp1Cont = document.getElementById('nav-item-info');
let tabStp2Cont = document.getElementById('nav-item-details');
let tabStp3Cont = document.getElementById('nav-user-info');

//busca todos los elementos con los respectivos nombres
let btns1 = Array.from(document.getElementsByName('paso1'));
let btns2 = Array.from(document.getElementsByName('paso2'));
let btns3 = Array.from(document.getElementsByName('paso3'));

//por cada elemento agrega la funcion de toggle tabs segun el tipo de boton
btns1.forEach(btn => {
    btn.addEventListener('click', (event) => {
        tabPaso1.classList.remove('active');
        tabPaso2.classList.remove('active');
        tabPaso3.classList.remove('active');
        
        tabStp1Cont.classList.remove('active');
        tabStp2Cont.classList.remove('active');
        tabStp3Cont.classList.remove('active');
        
        tabPaso1.classList.add('active');
        tabStp1Cont.classList.add('active');
    });
});

btns2.forEach(btn => {
    btn.addEventListener('click', (event) => {
        if(validation.validarParteUno()){
            //return;
        }
        
        tabPaso1.classList.remove('active');
        tabPaso2.classList.remove('active');
        tabPaso3.classList.remove('active');
        
        tabStp1Cont.classList.remove('active');
        tabStp2Cont.classList.remove('active');
        tabStp3Cont.classList.remove('active');
        
        tabPaso2.classList.add('active');
        tabStp2Cont.classList.add('active');
    });
});

btns3.forEach(btn => {
    btn.addEventListener('click', (event) => {
        tabPaso1.classList.remove('active');
        tabPaso2.classList.remove('active');
        tabPaso3.classList.remove('active');
        
        tabStp1Cont.classList.remove('active');
        tabStp2Cont.classList.remove('active');
        tabStp3Cont.classList.remove('active');
        
        tabPaso3.classList.add('active');
        tabStp3Cont.classList.add('active');
    });
});

/*
let btnPaso0 = document.getElementById('boton-paso0');
let btnPaso1 = document.getElementById('boton-paso1');
let btnPaso2 = document.getElementById('boton-paso2');

btnPaso1.addEventListener('click', (event) => {
    tabPaso1.classList.toggle('active');
    tabPaso2.classList.toggle('active')
    btnPaso1.classList.remove('active');
})

btnPaso2.addEventListener('click', (event) => {
    tabPaso2.classList.toggle('active');
    tabPaso3.classList.toggle('active')
    btnPaso2.classList.remove('active');
})*/

// Script para cambiar la máscara del tipo de contacto
let selectTypes = Array.from(document.getElementsByClassName('seleccionar-tipo'));
let phonePrevs = Array.from(document.getElementsByClassName('codigo-movil'));
let phoneConts = Array.from(document.getElementsByClassName('numero-contacto'));

function setContactTypeListener(){
    selectTypes = Array.from(document.getElementsByClassName('seleccionar-tipo'));
    phonePrevs = Array.from(document.getElementsByClassName('codigo-movil'));
    phoneConts = Array.from(document.getElementsByClassName('numero-contacto'));
    
    selectTypes.forEach(selectable => {
        selectable.addEventListener('change', (event) => {
            var i = selectTypes.indexOf(selectable);
            if(selectable.value === 'telefono_movil'){
                phonePrevs[i].classList.remove('d-none');
                phoneConts[i].style.width = '74%';
            }else{
                phonePrevs[i].classList.add('d-none');
                phoneConts[i].style.width = '100%';
            }
        });
    });
}

setContactTypeListener();





/*
let seleccionarTipo = document.getElementById('seleccionar-tipo');
let codigoMovil = document.getElementById('codigo-movil');
let numeroContacto = document.getElementById('numero-contacto');

seleccionarTipo.addEventListener('change', (event) => {

    if (seleccionarTipo.value === 'telefono_movil' ) {
        
        codigoMovil.classList.toggle('d-none');
        numeroContacto.style.width = '74%';

    } else {
        
        codigoMovil.classList.add('d-none');
        numeroContacto.style.width = '100%';
    }

})*/

// Script para los botones de agregar otro contacto
let agregarContacto = document.getElementById('agregar-contacto');
let rowContactos = document.getElementById('row-contactos');
const templateContacto =  //Template para añadir otro contacto
    `<div class="row">
    <div class="col">
    <div class="form-group">
        <label>Tipo de Contacto</label>
        <div class="selector-head">
            <span class="arrow"><i class="lni lni-chevron-down"></i></span>
            <select class=" seleccionar-tipo user-chosen-select">
                <option value="0" disabled>Selecciona el tipo de contacto a ingresar</option>
                <option value="telefono_fijo">Teléfono Fijo</option>
                <option value="telefono_movil">Móvil</option>
                <option value="whatsapp">WhatsApp</option>
            </select>
        </div>
        </div>
    </div>
    <div class="col">
    <div class="form-group">
        <label>Ingresa el número de contacto</label>
        <div class="selector-head">
            <select class="codigo-movil user-chosen-select w-25 d-none">
            <option value="0412">0412</option>
            <option value="0414">0414</option>
            <option value="0424">0424</option>
            <option value="0416">0416</option>
            <option value="0426">0426</option>
            </select>
            <input class="numero-contacto" name="price" type="text" placeholder="2028792" />
        </div>
        </div>
    </div>
    </div>`;

agregarContacto.addEventListener('click', (event) => {
    
    $(rowContactos).append(templateContacto);
    setContactTypeListener();
    
})

// Script para los botones de agregar otro archivo
const agregarArchivo = document.getElementById('agregar');
let rowImagenes = document.getElementById('row-imagenes');
const templateArchivo =  //Template para añadir otro contacto
    `<div class="row">
    <label class="text-dark mb-2">Cargar Archivo</label>
        <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupFile01">
    </div>
    </div>
    `;

agregarArchivo.addEventListener('click', (event) => {
    $(rowImagenes).append(templateArchivo);
    setContactTypeListener();
})

// let agregarArchivo = document.getElementById('agregar-archivo');

// 

// agregarArchivo.addEventListener('click', (event) => {
//     alert('hola')
//     
// })