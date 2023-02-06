<div class="nav-superior">
    <div class="container">
        <a href="#">
            <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logoAlt">
        </a>
        <div class="dropdown">
            <button class="btn-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-1.5x far fa-user"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><a class="dropdown-item" id="btn-logout" href="#">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Nav -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Logo -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBarGod" aria-controls="navBarGod" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navBarGod">
            <ul class="list-nav navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="<?php echo Url::base(); ?>"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-stethoscope"></i>Especialidades
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/medicos" ?>">Médicos</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/especialidades" ?>">Especialidedes</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo Url::base() . "/pacientes" ?>"><i class="fas fa-user-tie"></i>Pacientes</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-building"></i>Seguro
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/empresas" ?>">Empresa</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/seguros" ?>">Seguro</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-clipboard-check"></i>Facturación
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/factura/compra" ?>">Factura compra</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/factura/seguro" ?>">Factura seguro</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/factura/consulta" ?>">Factura consulta</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/factura/medico" ?>">Factura médico</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo Url::base() . "/insumos" ?>"><i class="fas fa-syringe"></i>Inventario</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-book-medical"></i>Consultas</a>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/consultas" ?>">Consultas</a></li>
                        <li><a class="dropdown-item" href="<?php echo Url::base() . "/citas" ?>">Citas</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin Nav -->