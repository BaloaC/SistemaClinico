export function addSiblingError(element, message){
    //let element = document.getElementById("elementId");
    //obtiene el elemento hermano siguiente
    let sibling = element.nextElementSibling;
    
    //compara si realmente existe el hermano y si es del tipo error
    if(sibling != null && sibling?.classList?.contains("error")){
        sibling.innerHTML = message;
    }else{
        //sino existe o no es error lo crea
        element.insertAdjacentHTML('afterend', `
            <p class="error">${message}</p>
        `);
    }
    
    //añade la clase error al primer elemento
    if(!element.classList.contains("error")){
        element.classList.add('error');
    } 
}
export function removeSiblingError(element){
    //let element = document.getElementById("");
    let sibling = element?.nextElementSibling;
    if(sibling != null && sibling?.classList?.contains("error")){
        sibling.parentElement.removeChild(sibling);
    }
    
    if(element?.classList?.contains("error")){
        element.classList.remove('error');
    }
}

export function removeSiblingErrors(elements){
    elements.forEach(element => {
        removeSiblingError(element);
    });
}

export function  msjAlert(id_element,message){
    document.getElementById(id_element).innerHTML=` 
						<div class="alert alert-danger" role="alert">
                        ${message}
						</div>`;

	document.getElementById(id_element).classList.replace('d-none', 'd-block');
	setInterval(()=>{
	    document.getElementById(id_element).classList.replace('d-block', 'd-none');
	},3000);
}

/*
export function addAlertError(element, message){
//let element = document.getElementById("elementId");
//obtiene el elemento hermano siguiente
    let sibling = element.nextElementSibling;
    
    //compara si realmente existe el hermano y si es del tipo error
    console.log(sibling)
    if(sibling != null && sibling?.classList?.contains("error")){
        sibling.innerHTML = message;
    }else{
        //sino existe o no es error lo crea
        element.insertAdjacentHTML('afterend', `
            <p class="alert alert-danger" id='mensaje-error' role="alert">
                ${message}
            </p>
        `);
    }
    
    //añade la clase error al primer elemento
    if(!element.classList.contains("error")){
        element.classList.add('error');
    } 
}


export function removeError(element){
    let sibling = element?.nextElementSibling;
    if(sibling != null && sibling?.classList?.contains("alert alert-danger")){
        sibling.parentElement.removeChild(sibling);
    }
    
    if(element?.classList?.contains("alert alert-danger")){
        element.classList.remove('alert alert-danger');
    }
}
*/