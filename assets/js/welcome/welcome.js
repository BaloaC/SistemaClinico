addEventListener('DOMContentLoaded', async (target) =>{ 

    target.preventDefault();

    const response = await fetch('http://127.0.0.1/codigo_backend/listarusuarios'),
    json = await response.json();

    let tbody = document.querySelector('#tbody-user');

    json.data.forEach(key =>{
        
        const user = '<tr>'
        + '<td>' + key.nombres + '</td>'
        + '<td>' + key.apellidos + '</td>'
        + '<td>' + key.correo + '</td>'
        + '</tr>'
        ;

        tbody.appendChild(user);
    });
})