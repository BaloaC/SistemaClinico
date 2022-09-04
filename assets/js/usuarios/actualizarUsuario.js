document.addEventListener('DOMContentLoaded', async () =>{
    
    const idUsuario = document.getElementById('idUsuario').value;

    try {
        
        if(idUsuario !== null && idUsuario > 0){
            
            const response = await fetch('http://127.0.0.1/proyectofeo/usuarios/consulta/' + idUsuario),

            json = await response.json();

            console.log(json);

            if(json.code === true){

                //Rellenar los inputs
                console.log('Consulta exitosa!');  

            } else{

                //La consulta no se ejecutó correctamente
                throw new Error('No se ha consultado correctamente el usuario');
            }
        } else{

            //El usuario id envíado no es correcto
            throw new Error('Usuario id inválido');
        }

    } catch (error) {
        
        alert(error);
    }
})

document.addEventListener("submit", async event => {

    event.preventDefault();

    const data = new FormData(event.target),
        values = Object.fromEntries(data.entries()),
        user = {

            nombres: values.nombres,
            apellidos: values.apellidos,
            correo: values.correo,
            idUsuario: values.idUsuario
        };

    try {

        const options = {

            method: "PUT",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(user),
        };

        const response = await fetch("http://127.0.0.1/proyectofeo/usuarios/actualizar", options);

        json = await response.json();

        console.log(json);

        if (json.code === true) {

            alert("Usuario actualizado correctamente");

        } else {

            throw new Error("El usuario no se ha registrado correctamente!");
        }
    } catch (error) {

        alert(error);
    }
});



