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
                <!-- <li><a class="dropdown-item" href="#">Perfil</a></li> -->
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
                <li class="nav-item"><a class="nav-link rol-1 rol-2 rol-3 rol-4 rol-5 rol-0" href="<?php echo Url::base() . "/home" ?>"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rol-1 rol-2 rol-4 rol-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-stethoscope"></i>Personal
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item rol-1 rol-2 rol-4 rol-5" href="<?php echo Url::base() . "/especialidades" ?>">Especialidades</a></li>
                        <li><a class="dropdown-item rol-1 rol-2 rol-4" href="<?php echo Url::base() . "/medicos" ?>">Médicos</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rol-1 rol-2 rol-4 rol-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-tie"></i>Atención médica
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item rol-1 rol-2 rol-4 rol-5" href="<?php echo Url::base() . "/consultas" ?>">Consultas</a>
                        <li><a class="dropdown-item rol-1 rol-2 rol-4 rol-5" href="<?php echo Url::base() . "/citas" ?>">Citas</a></li>
                        <li><a class="dropdown-item rol-1 rol-2 rol-4 rol-5" href="<?php echo Url::base() . "/examenes" ?>">Exámenes</a></li>
                        <li><a class="dropdown-item rol-1 rol-2 rol-4 rol-5" href="<?php echo Url::base() . "/pacientes" ?>">Pacientes</a></li>
                </li>
            </ul>
            </li>
            <!-- <li class="nav-item"><a class="nav-link" href="<?php echo Url::base() . "/pacientes" ?>"></i>Pacientes</a></li> -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rol-1 rol-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-building"></i>Gestión de seguros
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item rol-1 rol-2" href="<?php echo Url::base() . "/empresas" ?>">Empresa</a></li>
                    <li><a class="dropdown-item rol-1 rol-2" href="<?php echo Url::base() . "/seguros" ?>">Seguro</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rol-1 rol-2 rol-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-clipboard-check"></i>Facturación
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item rol-1 rol-2 rol-3" href="<?php echo Url::base() . "/factura/compra" ?>">Factura compra</a></li>
                    <li><a class="dropdown-item rol-1 rol-2 rol-3" href="<?php echo Url::base() . "/factura/seguro" ?>">Factura seguro</a></li>
                    <li><a class="dropdown-item rol-1 rol-2 rol-3" href="<?php echo Url::base() . "/factura/consulta" ?>">Factura consulta</a></li>
                    <li><a class="dropdown-item rol-1 rol-2 rol-3" href="<?php echo Url::base() . "/factura/medico" ?>">Factura médico</a></li>
                    <!-- <li><a class="dropdown-item" href="<?php echo Url::base() . "/proveedores" ?>">Proveedores</a></li> -->
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rol-1 rol-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-syringe"></i>Inventario
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item rol-1 rol-2" href="<?php echo Url::base() . "/proveedores" ?>">Proveedores</a></li>
                    <li><a class="dropdown-item rol-1 rol-2" href="<?php echo Url::base() . "/insumos" ?>">Insumos</a></li>
                </ul>
            </li>
            <!-- <li class="nav-item"><a class="nav-link" href="<?php echo Url::base() . "/insumos" ?>"><i class="fas fa-syringe"></i>Inventario</a></li> -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle rol-1 rol-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-book-medical"></i>Reportes</a>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item rol-1" href="<?php echo Url::base() . "/auditoria" ?>">Auditoria</a></li>
                    <li><a class="dropdown-item rol-1" onclick="openPopup('pdf/seguros')" href="#">Total de seguros</a></li>
                    <li><a class="dropdown-item rol-1" onclick="openPopup('pdf/insumosfaltantes')" href="#">Insumos faltantes</a></li>
                </ul>
            </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin Nav -->