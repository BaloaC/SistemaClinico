// Template para la opción 2
let templatePreguntas = `
    <div>
        <label for="respuesta1" class="mt-3">Cuál es el apodo de tu infancia</label>
        <input class="form-control" type="text" name="respuesta1" placeholder="Introduce la respuesta a la pregunta de seguridad">
        <label for="respuesta2" class="mt-3">Cuál es tu programa de televisión favorito</label>
        <input class="form-control" type="text" name="respuesta2" placeholder="Introduce la respuesta a la pregunta de seguridad">
        <div class="text-center mt-3"><button type="submit" class="btn btn-primary w-50">Enviar</button></div>
    </div>
`;

// Template para la opción 1
let templatePin = `
    <div>
        <label for="pin" class="mt-3">Pin de Seguridad</label>
        <input class="form-control" type="text" name="pin" placeholder="Introduzca el pin de seguridad de seguridad de 6 dígitos">
        <div class="text-center mt-3"><button type="submit" class="btn btn-primary w-50">Enviar</button></div>
    </div>
`

let childForm = document.getElementById('childForm');
let selectOpcion = document.getElementById("select-metodo");

selectOpcion.addEventListener('change', (event) => {
    
    if ( selectOpcion.value == 2 ) {
        // Verificamos si ya hay un template agregado
        if (childForm.hasChildNodes()) {
            $($(childForm).children()).replaceWith(templatePreguntas);    
        
        } else {
            //Si no lo hay entonces lo agregamos normal, sin reemplzar nada
            $(childForm).append(templatePreguntas);
        }

    } else if ( selectOpcion.value == 1 ) {
        if (childForm.hasChildNodes()) {  
            $($(childForm).children()).replaceWith(templatePin);

        } else {
            $(childForm).append(templatePin);

        }
    }
})
