const path = location.pathname.split('/');

// Animación
document.getElementById("siguiente").addEventListener("click", (event) => {
            
    formInfo = document.getElementById("form-info");
    formPreguntas = document.getElementById("form-preguntas");
    
    formInfo.classList.toggle("op-0");
    setTimeout(() => {
        formPreguntas.classList.add("form-centrar");
    }, 500);
})

document.addEventListener("submit", async e => {

    e.preventDefault();
    const $alert = document.querySelector(".alert");

    try {

        const formData = new FormData(e.target),
            data = {};

        formData.forEach((value, key) => (data[key] = value));

        if (data.clave !== data.confirmarClave) throw { message: "Las contraseñas no coinciden" };
        if (!(new RegExp(/^[1-9A-Za-zÁáÉéÍíÓóÚúÑñÜü\s]+$/).test(data.nombre))) throw { message: "Nombre de usuario inválido" };
        if (!(data.rol > 0 && data.rol <= 5)) throw { message: "Nivel de usuario inválido" };

        const options = {

            method: "POST",
            mode: "cors", //Opcional
            headers: {
                "Content-type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(data),
        };

        const response = await fetch(`/${path[1]}/usuarios`, options);

        json = await response.json();

        if (!json.code) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.add("alert-success");
        $alert.classList.remove("d-none");
        $alert.textContent = "Usuario registrado correctamente!";

        e.target.reset();

    } catch (error) {

        let message = error.message || error.result.message;

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = `${message}`;
    }
});
