<html class="no-js" lang="zxx">

<head>
    <title>Panel - ClassiGrids Classified Ads and Listing Website Template</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../assets/css/preloader.css"/>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <script src="../utils/header.js"></script>

    <section class="dashboard section default-form-style">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="dashboard-sidebar">
                        <div class="user-image">
                            <img src="../assets/images/items-grid/author-1.jpg" alt="#">
                            <h3>Steve Aldridge
                                <span><a href="javascript:void(0)">@username</a></span>
                            </h3>
                        </div>
                        <div class="dashboard-menu">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#perfil" type="button" role="tab" aria-controls="perfil" aria-selected="true"><i class="lni lni-pencil-alt"></i> Perfil</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#mis-servicios" type="button" role="tab" aria-controls="mis-servicios" aria-selected="false"><i class="lni lni-bolt-alt"></i> Mis Servicios</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#crear-servicios" type="button" role="tab" aria-controls="crear-servicios" aria-selected="false"><i class="lni lni-circle-plus"></i>Crear Servicios</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#mi-membresia" type="button" role="tab" aria-controls="mi-membresia" aria-selected="false"><i class="lni lni-licence"></i> Mi Membresía</a>
                                </li>
                                <li class="nav-item mb-5" role="presentation">
                                    <a class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#eliminar-cuenta" type="button" role="tab" aria-controls="eliminar-cuenta" aria-selected="false"><i class="lni lni-trash"></i> Eliminar Cuenta</a>
                                </li>
                            </ul>
                            <div class="button">
                                <a class="btn" href="javascript:void(0)">Cerrar Sesión</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-9 col-md-8 col-12 tab-content" id="myTabContent">
                    <!-- Información de perfil -->
                    <div class="tab-pane fade show active" id="perfil" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="">
                            <div class="main-content">
                                <div class="dashboard-block mt-0 profile-settings-block">
                                    <h3 class="block-title">Información de Perfil</h3>

                                    <div class="row">
                                        <div class="col-lg-5 box-img">
                                            <div class="text-center">
                                                <img class="rounded-circle mb-3" src="../assets/images/items-grid/author-1.jpg" alt="#">
                                                <div class="button"><button class="btn" onclick="cancelarEdicion()" id="editar-perfil">Editar Perfil</button></div>
                                                <span><a href="javascript:void(0);" class="mt-1" onclick="cancelarCambio()" id="cambiar-clave">Cambiar Contraseña</a></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 info-box" id="user-info">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <h6>Username</h6>
                                                        <p>nombre</p>
                                                    </div>
                                                    <div>
                                                        <h6>Nombre</h6>
                                                        <p>nombre</p>
                                                    </div>
                                                    <div>
                                                        <h6>Género</h6>
                                                        <p>Femenino</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div>
                                                        <h6>Teléfono</h6>
                                                        <p>0404</p>
                                                    </div>
                                                    <div>
                                                        <h6>Correo</h6>
                                                        <p>correo@.com</p>
                                                    </div>
                                                    <div>
                                                        <h6>Membresía</h6>
                                                        <p>Plan x</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-7 d-none" id="user-edit">
                                            <form class="profile-setting-form" id="form-profile-setting" method="post" action="#">
                                                <div class="d-none" id="mensaje-error-datos"></div>

                                                <div class="row">

                                                    <div class="col-lg-6 col-12">

                                                        <div class="form-group">
                                                            <label>Nombre Completo</label>
                                                            <input name="nombre_completo" id="nombreCompleto" required type="text" placeholder="Steve Aldridge">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nombre de Usuario</label>
                                                            <input name="nombre_usuario" id="nombreUsuario" type="text" required placeholder="steve34">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Género*</label>
                                                            <div class="selector-head">
                                                                <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                                                                <select class="user-chosen-select" name="genero" id="vGenero" required>
                                                                    <option value="sin_seleccion">Seleccione una opción</option>
                                                                    <option value="Hombre">Hombre</option>
                                                                    <option value="Mujer">Mujer</option>
                                                                    <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group">
                                                            <label>Teléfono</label>
                                                            <input name="usernames" type="number" placeholder="412-5657849">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Correo</label>
                                                            <input name="last-name" type="text"
                                                                placeholder="username@gmail.com">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <div class="form-group button mb-0">
                                                        <div onclick="cancelarEdicion()" class="btn btn-secondary">Cancelar</div>
                                                        <button type="submit" class="btn">Actualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-12 col-lg-7 d-none opacity" id="password-edit">
                                            <div class="alert alert-danger d-none w-full" id='mensaje-error-clave' role="alert">
                                            </div>
                                            <form class="default-form-style" method="post" id="form-clave-modificar" action="#">
                                                <div class="d-none" id="mensaje-error-clave"></div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Contraseña Actual</label>
                                                            <input name="clave_Actual" id="claveVieja" type="password" required placeholder="Antigua Contraseña">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Nueva Contraseña</label>
                                                            <input name="nueva-clave" id="claveNueva" type="password" required placeholder="Nueva Contraseña">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Repita la Contraseña</label>
                                                            <input name="repetir-clave" type="password" required placeholder="Repetir Contraseña">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <div class="form-group button mb-0">
                                                            <div class="btn btn-secondary" onclick="cancelarCambio()" id="cancelar-clave">Cancelar</div>
                                                            <button type="submit" class="btn">Cambiar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Mis servicios -->
                    <div class="tab-pane fade" id="mis-servicios" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div>
                            <div class="main-content">
                                <div class="dashboard-block mt-0">
                                    <h3 class="block-title">Mis Anuncios</h3>
                                    <nav class="list-nav">
                                        <ul>
                                            <li class="active"><a href="javascript:void(0)">Todos los servicios<span>42</span></a></li>
                                            <li><a href="javascript:void(0)">Activos <span>88</span></a></li>
                                            <li><a href="javascript:void(0)">Expirados <span>55</span></a></li>
                                        </ul>
                                    </nav>

                                    <div class="my-items" id="item-inner">

                                        <div class="item-list-title">
                                            <div class="row align-items-center">
                                                <div class="col-lg-5 col-md-5 col-12">
                                                    <p>Job Title</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <p>Category</p>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <p>Condition</p>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-12 align-right">
                                                    <p>Action</p>
                                                </div>
                                            </div>
                                        </div>


                                        <script src="../assets/js/dashboard/my-items/mostrarItems.js"></script>


                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                <li><a href="javascript:void(0)">1</a></li>
                                                <li class="active"><a href="javascript:void(0)">2</a></li>
                                                <li><a href="javascript:void(0)">3</a></li>
                                                <li><a href="javascript:void(0)">4</a></li>
                                                <li><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
                                            </ul>

                                            <div class="purple"> <a href="../dashboard/crear-servicios.php" id="agregar-archivo" class="d-flex me-2"><i class="lni lni-circle-plus purple fs-4"></i>
                                                    <p class="purple">&nbsp;Añadir servicio</p>
                                                </a> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Crear servicios -->
                    <div class="tab-pane fade" id="crear-servicios" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="dashboard-block mt-0">
                            <h3 class="block-title">Crear Anuncio</h3>
                            <div class="inner-block">
                                <div class="post-ad-tab">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-item-info-tab" name="paso1">
                                                <span class="serial">01</span> Paso
                                                <span class="sub-title">Agrega información básica</span>
                                            </button>
                                            <button class="nav-link" id="nav-item-details-tab" name="paso2">
                                                <span class="serial">02</span> Paso
                                                <span class="sub-title">Agrega información de contacto</span>
                                            </button>
                                            <button class="nav-link" id="nav-user-info-tab" name="paso3">
                                                <span class="serial">03</span> Paso
                                                <span class="sub-title">Agrega las imágenes del servicio</span>
                                            </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <form class="default-form-style mt-4" method="post" action="#">
                                            <div class="tab-pane fade show active" id="nav-item-info" role="tabpanel" aria-labelledby="nav-item-info-tab">
                                                <div class="step-one-content">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Título</label>
                                                                <input id='tituloServicio' name="title" type="text" placeholder="Insertar Título" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Descripción</label>
                                                                <input id='descripcionServicio' name="description" type="text" placeholder="Insertar Descripción del Servicio" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Categoría</label>
                                                                <div class="selector-head">
                                                                    <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                                                                    <select class="user-chosen-select" id='categoria'>
                                                                        <option value="sin_categoria">Seleccionar categoría</option>
                                                                        <option value="1">Mobile Phones</option>
                                                                        <option value="2">Electronics</option>
                                                                        <option value="3">Computers</option>
                                                                        <option value="4">Headphones</option>
                                                                        <option value="5">Furnitures</option>
                                                                        <option value="6">Books</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-4">
                                                                <div class="google-map">
                                                                    <div class="mapouter">
                                                                        <div class="gmap_canvas">
                                                                            <iframe width="100%" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br />
                                                                            <style>
                                                                                .mapouter {
                                                                                    position: relative;
                                                                                    text-align: right;
                                                                                    height: 300px;
                                                                                    width: 100%;
                                                                                }
                                                                            </style><a href="https://www.embedgooglemap.net">embed google maps wordpress</a>
                                                                            <style>
                                                                                .gmap_canvas {
                                                                                    overflow: hidden;
                                                                                    background: none !important;
                                                                                    height: 300px;
                                                                                    width: 100%;
                                                                                }
                                                                            </style>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group button d-flex justify-content-end mb-0">
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <button class="btn" name="paso2" type="button">
                                                                        Próximo Paso
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade show" id="nav-item-details" role="tabpanel" aria-labelledby="nav-item-details-tab">
                                                <div class="step-two-content">
                                                    <div class="row">
                                                        <div id="row-contactos" class="col-12">
                                                            <div class="form-group">
                                                                <label>Tipo de Contacto</label>
                                                                <div class="selector-head">
                                                                    <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                                                                    <select class="user-chosen-select seleccionar-tipo">
                                                                        <option value="0" disabled>Selecciona el tipo de contacto a ingresar</option>
                                                                        <option value="telefono_fijo">Teléfono Fijo</option>
                                                                        <option value="telefono_movil">Móvil</option>
                                                                        <option value="whatsapp">WhatsApp</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Ingresa el número de contacto</label>
                                                                <div class="selector-head">
                                                                    <select class="user-chosen-select w-25 d-none codigo-movil">
                                                                        <option value="0412">0412</option>
                                                                        <option value="0414">0414</option>
                                                                        <option value="0424">0424</option>
                                                                        <option value="0416">0416</option>
                                                                        <option value="0426">0426</option>
                                                                    </select>
                                                                    <input class="numero-contacto" name="price" type="text" placeholder="2028792" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 form-group">
                                                                <a id="agregar-contacto" href="javaScript:void(0)" class="d-flex"><i class="lni lni-circle-plus fs-4 me-1"></i>
                                                                    <p>&nbsp;Agregar otro contacto</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group button d-flex justify-content-end mb-0">
                                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <button class="btn" name="paso3" type="button"> Próximo Paso </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade show" id="nav-user-info" role="tabpanel" aria-labelledby="nav-user-info-tab">
                                                <div class="step-three-content">
                                                    <div class="row">
                                                        <div id="row-imagenes" class="col-12">
                                                            <label class="text-dark mb-2">Cargar Archivo</label>
                                                            <div class="input-group mb-3">
                                                                <input type="file" class="form-control" id="inputGroupFile01">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class=" col-12 form-group">
                                                                <a id="agregar" href="javaScript:void(0)" class="d-flex mt-2"><i class="lni lni-circle-plus fs-4 me-1"></i>
                                                                    <p>&nbsp;Agregar otro archivo</p>
                                                                </a>
                                                            </div>

                                                        </div>
                                                        <div class="row form-group button d-flex justify-content-end mb-0">
                                                            <button type="submit" class="btn"> Enviar </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mi membresía -->
                    <div class="tab-pane fade" id="mi-membresia" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                        <div class="dashboard-block mt-0">
                            <h3 class="block-title">Mi Membresía</h3>
                            <div class="main-content">
                                <div class="row content-membership container">
                                    <div class="col-12 col-md-6">
                                        <h4>Descripción de la Membresía</h4>
                                        <ul>
                                            <li>Un listado</li>
                                            <li>Pantalla de contactos</li>
                                            <li>Galería de imágenes</li>
                                            <li>60 días de disponibilidad</li>
                                            <li>No destacado</li>
                                            <li>Lema de negocios</li>
                                        </ul>
                                        <p class="text-dark fw-bold">Vence:</p>
                                        <div>
                                            <i class="lni lni-calendar fs-4 purple"></i>
                                            <p>02-02-2023</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div>
                                            <h4>Plan</h4>
                                            <h2>Estándar</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Eliminar Cuenta -->
                    <div class="tab-pane fade" id="eliminar-cuenta" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                        <div class="main-content">
                            <div class="dashboard-block close-content mt-0">
                                <h2>Eliminar Cuenta</h2>
                                <h4>
                                    ¿Está seguro que desea eliminar su cuenta y toda la
                                    información relacionada a ella?
                                </h4>
                                <div class="button">
                                    <a href="javascript:void(0)" class="btn">Borrar</a>
                                    <a href="javascript:void(0)" class="btn btn-alt">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>

    <!-- Starts edit modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="default-form-style" method="post" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                        <button onclick="toggleModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Título</label>
                                    <input name="title" type="text" placeholder="Insertar Título" />
                                </div>
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input name="description" type="text" placeholder="Insertar Descripción del Servicio" />
                                </div>
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <div class="selector-head">
                                        <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                                        <select class="user-chosen-select">
                                            <option value="none">
                                                Seleccionar categoría
                                            </option>
                                            <option value="none">
                                                Mobile Phones
                                            </option>
                                            <option value="none">Electronics</option>
                                            <option value="none">Computers</option>
                                            <option value="none">Headphones</option>
                                            <option value="none">Furnitures</option>
                                            <option value="none">Books</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="google-map">
                                        <div class="mapouter">
                                            <div class="gmap_canvas">
                                                <iframe width="100%" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br />
                                                <style>
                                                    .mapouter {
                                                        position: relative;
                                                        text-align: right;
                                                        height: 300px;
                                                        width: 100%;
                                                    }
                                                </style><a href="https://www.embedgooglemap.net">embed google maps wordpress</a>
                                                <style>
                                                    .gmap_canvas {
                                                        overflow: hidden;
                                                        background: none !important;
                                                        height: 300px;
                                                        width: 100%;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="row-contactos" class="col-12">
                                <div class="form-group">
                                    <label>Tipo de Contacto</label>
                                    <div class="selector-head">
                                        <span class="arrow"><i class="lni lni-chevron-down"></i></span>
                                        <select id="seleccionar-tipo" class="user-chosen-select">
                                            <option value="0" disabled>Selecciona el tipo de contacto a ingresar</option>
                                            <option value="telefono_fijo">Teléfono Fijo</option>
                                            <option value="telefono_movil">Móvil</option>
                                            <option value="whatsapp">WhatsApp</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ingresa el número de contacto</label>
                                    <div class="selector-head">
                                        <select id="codigo-movil" class="user-chosen-select w-25 d-none">
                                            <option value="0412">0412</option>
                                            <option value="0414">0414</option>
                                            <option value="0424">0424</option>
                                            <option value="0416">0416</option>
                                            <option value="0426">0426</option>
                                        </select>
                                        <input id="numero-contacto" name="price" type="text" placeholder="2028792" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class=" col-12 form-group">
                                    <a id="agregar-contacto" href="javaScript:void(0)" class="d-flex">
                                        <i class="lni lni-circle-plus fs-4 me-1"></i>
                                        <p>&nbsp;Agregar otro contacto</p>
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div id="row-imagenes" class="col-12">
                                    <label class="text-dark mb-2">Cargar Archivo</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="inputGroupFile01">
                                    </div>
                                </div>
                                <div class="col-12 form-group">
                                    <a id="agregar" href="javaScript:void(0)" class="d-flex mt-2"><i class="lni lni-circle-plus fs-4 me-1"></i>
                                        <p>&nbsp;Agregar otro arcivo</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="button">
                            <button type="button" onclick="toggleModal()" class="btn btn-alt" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn">Enviar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Ends edit modal -->

    <a href="#" class="scroll-top btn-hover" style="display: none;">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="../assets/libs/wow/wow.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="../utils/header.js"></script> 
    <script src="../utils/head.js"></script>
    <script src="../utils/scripts.js"></script>
    <script src="../assets/js/dashboard/profile/botonesOpciones.js"></script>
    <script type="module" src="../assets/js/dashboard/crearServicios/servicios.js"></script>
    <script src="../assets/js/dashboard/profile/validarSettingsUser.js" type="module"></script>
    <script src="../assets/js/dashboard/profile/validarClaveUser.js" type="module"></script>
    <script type="module" src="../assets/js/dashboard/crearServicios/validarServicios.js"></script>

    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-body input').val(recipient)
        })

        function toggleModal() {
            $('#exampleModal').modal("toggle");
        }
    </script>
</body>

</html>