let url = "http://localhost/servicios/";
templateLinks = `
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="${url}assets/css/style.css">
    <link rel="stylesheet" href="${url}assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="${url}assets/libs/Linelcons/LineIcons.2.0.css" />
    <link rel="stylesheet" href="${url}assets/libs/animate/animate.css" />
    <link rel="stylesheet" href="${url}assets/libs/tinyslider/tiny-slider.css" />
    <link rel="stylesheet" href="${url}assets/libs/glightbox/glightbox.min.css" />
    <link rel="stylesheet" href="${url}assets/css/main.css" />
`
let head = document.head;

addEventListener('DOMContentLoaded', (event) => {
    $(head).prepend(templateLinks);
});

