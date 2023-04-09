const disabledInputs = document.querySelectorAll(".form-control[disabled]");

document.getElementById("s-tipo_paciente").addEventListener("change", e => {

    const subMenus = document.querySelector(".sub-menus");
    let counter = 1,
    selectedSubMenu = e.target.value;

    for (const subMenu of subMenus.children) {
        
        const subMenuInputs = subMenu.querySelectorAll("input, select");

        if((selectedSubMenu == 3 && counter == 2) || (selectedSubMenu == 4 && counter == 1)){
        
            subMenuInputs.forEach(el => {
                el.disabled = false;
            });

            subMenu.classList.remove("opacity-0");
            setTimeout(() => {
                subMenu.classList.remove("d-none");
            }, 550);
            
        } else {

            subMenuInputs.forEach(el => {
                el.disabled = true;
            })

            subMenu.classList.add("opacity-0");
            setTimeout(() => {
                subMenu.classList.add("d-none");
            }, 550);
        }
        
        counter++;
        console.log(counter);
    }

    // subMenus.forEach(el => {
    //     console.log(el);
    // });

    // console.log(document.querySelector(".sub-menus").childNodes[1]);
})


// const disabledInputs = document.querySelectorAll(".form-control[disabled]");

// $("#s-tipo_paciente").on("change", function (e) {

//     disabledInputs.forEach(el => {
//         if (e.target.value == 2) {

//             document.querySelector(".extra-seguro").classList.add("opacity-0");
//             setTimeout(() => {
//                 document.querySelector(".extra-seguro").classList.add("d-none");
//             }, 550);
//             el.disabled = false;
//         } else {
//             document.querySelector(".extra-seguro").classList.remove("d-none");
//             setTimeout(() => {
//                 document.querySelector(".extra-seguro").classList.remove("opacity-0");
//             }, 100);
//             el.disabled = true;
//         }
//     })
// })

// $("#s-tipo_paciente").on("change", function (e) {

//     disabledInputs.forEach(el => {
//         if (e.target.value == 2) {

//             document.querySelector(".extra-seguro").classList.add("opacity-0");
//             setTimeout(() => {
//                 document.querySelector(".extra-seguro").classList.add("d-none");
//             }, 550);
//             el.disabled = false;
//         } else {
//             document.querySelector(".extra-seguro").classList.remove("d-none");
//             setTimeout(() => {
//                 document.querySelector(".extra-seguro").classList.remove("opacity-0");
//             }, 100);
//             el.disabled = true;
//         }
//     })
// })