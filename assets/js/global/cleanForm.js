function cleanForm(form) {
    Array.from(document.getElementById(form)?.elements)?.forEach(element => {
        if (element.nodeName === "SELECT") {
            
            $(`#${element.id}`).val([]).change();

        } else if(element.nodeName === "INPUT"){

            if(element.type === "checkbox"){
                element.checked = false;
                element.dispatchEvent(new Event("change"));
            } else {

                document.getElementById(form).reset();
                // element.value = "";
            }
        }
        
    })
}

window.cleanForm = cleanForm;