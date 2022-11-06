<!-- Nav -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img class="w-50" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logoAlt">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBarGod" aria-controls="navBarGod" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navBarGod">
            <ul class="list-nav navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Administrador</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Especialidades</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Pacientes</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Facturacion</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Inventario</a></li>
                <li class="nav-item" id="usuario-id"><a class="nav-link" href="#">Usuario</a></li>
                <li class="nav-item"><a class="nav-link" id="btn-logout" href="#">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin Nav -->