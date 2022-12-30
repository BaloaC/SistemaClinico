const urlBase = "http://localhost/servicios/";
let body = document.body;
templateHeader = `
<header class="header navbar-area sticky">
    <div class="container">
        <div class="row align-items-center">
        <div class="col-lg-12">
            <div class="nav-inner">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.html"><img src="../assets/images/logo/logo.svg" alt="Logo" /></a>
                <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent" >
                <ul id="nav" class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="${urlBase}home.php" aria-label="Toggle navigation">Home</a></li>
                    <li class="nav-item"><a href="${urlBase}servicios/servicio.php" aria-label="Toggle navigation">Servicios</a></li>
                    <li class="nav-item"><a href="${urlBase}servicios/servicio.php" aria-label="Toggle navigation">Planes</a></li>
                    <li class="nav-item"><a href="${urlBase}dashboard/profile-settings.php" aria-label="Toggle navigation">Perfil</a></li>
                </ul>
                </div>
                <div class="login-button">
                <ul>
                    <li><a href="javascript:void(0);"><i class="lni lni-enter"></i>Cerrar sesión</a></li>
                    <li><a href="${urlBase}login/login.php"><i class="lni lni-enter"></i>Iniciar Sesión</a></li>
                    <li><a href="${urlBase}login/user-registration.php"><i class="lni lni-user"></i>Registrate</a></li>
                </ul>
                </div>
                <!-- <div class="button header-button"><a href="post-item.html" class="btn">Post an Ad</a></div> -->
            </nav>
            </div>
        </div>
        </div>
    </div>
</header>
`

addEventListener('DOMContentLoaded', (event) => {
    $(body).prepend(templateHeader);
});
