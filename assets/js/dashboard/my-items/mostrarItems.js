addItem(0, "", "prueba", 200, "Carros");
try {
    fetch("url aqui", {
        method: "GET"
        //method: "POST",
        //body: formData
    })
        .then((response) => {
            console.log(response);
            if (response.ok) {
                //si todo sale bien va por aqui
                //array de servicios
                //var itemArray = [];
                //itemArray = response;

                //agrega todos los servicios que retornen de la respuesta al contenedor de items
                //itemArray.forEach((service) => {
                //    addItem(service.id, service.images[0], service.title, service.price, service.category);
                //});
            } else {
                //si la peticion es distinta a 200 - 299
                //document.getElementById('mensaje-error-logueo').classList.replace('d-none', 'd-block');

                setTimeout(() => {
                    //document.getElementById('mensaje-error-logueo').classList.replace('d-block', 'd-none');
                }, 3000);

            }
        })
        .catch((error) => {
            //si no se puede realizar la peticion 
            document.getElementById('mensaje-error-servidor').classList.replace('d-none', 'd-block');

            setTimeout(() => {
                document.getElementById('mensaje-error-servidor').classList.replace('d-block', 'd-none');
            }, 3000);
        });
} catch (error) {
    form.reset();
    document.getElementById('mensaje-error-servidor').classList.replace('d-none', 'd-block');

    setTimeout(() => {
        document.getElementById('mensaje-error-servidor').classList.replace('d-block', 'd-none');
    }, 3000);

}

function addItem(id, imgURL, title, price, category) {
    //contenedor de items
    let itemInner = document.getElementById('item-inner');

    itemInner.innerHTML +=
        `
    <div class="single-item-list" id="${id}">
    <div class="row align-items-center">
        <div class="col-lg-5 col-md-5 col-12">
            <div class="item-image">
                <img src="${imgURL}" alt="#">
                <div class="content">
                    <h3 class="title"><a href="javascript:void(0)">${title}</a></h3>
                    <span class="price">${price}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-12">
            <p>${category}</p>
        </div>
        <div class="col-lg-2 col-md-2 col-12">
            <p>New</p>
        </div>
        <div class="col-lg-3 col-md-3 col-12 align-right">
            <ul class="action-btn">
                <li><a href="#" onclick="toggleModal()"><span class="lni lni-pencil"></span></a></li>
                <!-- <li><a href="javascript:void(0)"><i class="lni lni-eye"></i></a></li> -->
                <li><a href="javascript:void(0)" class="delete"><i class="lni lni-trash"></i></a></li>
            </ul>
        </div>
    </div>
</div>
    `;


}