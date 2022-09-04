document.addEventListener("DOMContentLoaded", async () => {

    try {
        
        const response = await fetch("http://127.0.0.1/proyectofeo/usuarios/consulta"),

        json = await response.json();

        console.log(json);

        if (json.code === true) {

            console.log("Consulta exitosa");

        } else {

            throw new Error("No se ha consultado correctamente los datos");
        }
    } catch (error) {

        alert(error);
    }
});
