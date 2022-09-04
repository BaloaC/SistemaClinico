document.addEventListener("submit", async event => {

    event.preventDefault();

    const data = new FormData(event.target),
        values = Object.fromEntries(data.entries()),
        user = {

            nombres: values.nombres,
            apellidos: values.apellidos,
            correo: values.correo,
        };

    try {

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(user),
        };

        const response = await fetch("http://127.0.0.1/proyectofeo/usuarios/registrar", options);

        json = await response.json();

        console.log(json);

        if (json.code === true) {

            alert("Usuario registrado correctamente");

        } else {

            throw new Error("El usuario no se ha registrado correctamente!");
        }
    } catch (error) {

        alert(error);
    }
});
