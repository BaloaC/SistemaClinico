let urlB = "http://localhost/servicios/";
templateScript = `
    <script src="${urlB}assets/js/main.js"></script>
    <script src="${urlB}assets/libs/bootstrap/bootstrap.min.js"></script>
    <script src="${urlB}assets/libs/wow/wow.min.js"></script>
    <script src="${urlB}assets/libs/tinyslider/tiny-slider.js"></script>
    <script src="${urlB}assets/libs/glightbox/glightbox.min.js"></script>
`

let bodyF = document.body;
addEventListener('DOMContentLoaded', (event) => {
    $(bodyF).append(templateScript);
});
