<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    Panel - ClassiGrids Classified Ads and Listing Website Template
  </title>
  <link rel="stylesheet" href="../assets/libs/bootstrap/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lato&amp;display=swap" rel="stylesheet" />
  <?php include "../extras/utils/head.php" ?>


</head>

<body>
  <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

  <div class="preloader" style="opacity: 0; display: none">
    <div class="preloader-inner">
      <div class="preloader-icon">
        <span></span>
        <span></span>
      </div>
    </div>
  </div>

 <?php include_once "../extras/utils/header.php" ; ?>
 <?php include_once "../extras/utils/breadcrumbs.php" ; ?>


  <section class="dashboard section">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
          <div class="dashboard-sidebar">
            <div class="user-image">
              <img src="../assets/images/items-grid/author-1.jpg" alt="#" />
              <h3>
                Steve Aldridge
                <span><a href="javascript:void(0)">@username</a></span>
              </h3>
            </div>
            <div class="dashboard-menu">
                <ul>
                  <li> <a class="active" href="../dashboard/dashboard.php" ><i class="lni lni-dashboard"></i> Panel</a> </li>
                  <li><a href="../dashboard/profile-settings.php"><i class="lni lni-pencil-alt"></i> Perfil</a></li>
                  <li> <a href="../dashboard/mis-servicios.php"><i class="lni lni-bolt-alt"></i> Mis Anuncios</a> </li>
                  <li> <a href="../dashboard/favourite-items.php"><i class="lni lni-heart"></i> Favoritos</a> </li>
                  <li> <a href="../dashboard/crear-servicios.php"><i class="lni lni-circle-plus"></i> Publicar</a> </li>
                  <li> <a href="../dashboard/bookmarked-items.php"><i class="lni lni-bookmark"></i> Marcadores</a> </li>
                  <li> <a href="../dashboard/messages.php"><i class="lni lni-envelope"></i> Mensajería</a> </li>
                  <li> <a href="../dashboard/delete-account.php"><i class="lni lni-trash"></i> Eliminar Cuenta</a> </li>
                  <li> <a href="../dashboard/invoice.php"><i class="lni lni-printer"></i> Factura</a> </li>
                </ul>
              <div class="button">
                <a class="btn" href="javascript:void(0)">Cerrar Sesión</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 col-12">
          <div class="main-content">
            <div class="dashboard-block mt-0">
              <h3 class="block-title">Crear Anuncio</h3>
              <div class="inner-block">
                <div class="post-ad-tab">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-item-info-tab" data-bs-toggle="tab" data-bs-target="#nav-item-info" type="button" role="tab" aria-controls="nav-item-info" aria-selected="true">
                        <span class="serial">01</span> Paso
                        <span class="sub-title">Agrega información básica</span>
                      </button>
                      <button class="nav-link" id="nav-item-details-tab" data-bs-toggle="tab" data-bs-target="#nav-item-details" type="button" role="tab" aria-controls="nav-item-details" aria-selected="false">
                        <span class="serial">02</span> Paso
                        <span class="sub-title">Agrega información de contacto</span>
                      </button>
                      <button class="nav-link" id="nav-user-info-tab" data-bs-toggle="tab" data-bs-target="#nav-user-info" type="button" role="tab" aria-controls="nav-user-info" aria-selected="false">
                        <span class="serial">03</span> Paso
                        <span class="sub-title">Agrega las imágenes del servicio</span>
                      </button>
                    </div>
                  </nav>

                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-item-info" role="tabpanel" aria-labelledby="nav-item-info-tab">
                      <div class="step-one-content">
                        <form class="default-form-style" method="post" action="#">
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
                              <div class="form-group button d-flex justify-content-end mb-0">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <button class="btn" id="boton-paso1" data-bs-toggle="tab" data-bs-target="#nav-item-details" type="button" role="tab" aria-controls="nav-item-details" aria-selected="false">
                                    Próximo Paso
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="nav-item-details" role="tabpanel" aria-labelledby="nav-item-details-tab">
                      <div class="step-two-content">
                        <form class="default-form-style" method="post" action="#">
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
                            <div> <a id="agregar-contacto" href="javaScript:void(0)" class="d-flex"><i class="lni lni-circle-plus purple fs-4 me-1"></i><p>Agregar otro contacto</p></a> </div>
                            <div class="form-group button d-flex justify-content-end mb-0">
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="btn" id="boton-paso2" data-bs-toggle="tab" data-bs-target="#nav-user-info"> Próximo Paso </button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="nav-user-info" role="tabpanel" aria-labelledby="nav-user-info-tab">
                      <div class="step-three-content">
                        <form class="default-form-style" method="post" action="#">
                          <div class="row">
                            <div id="row-imagenes" class="col-12">
                              <label class="text-dark mb-2">Cargar Archivo</label>
                              <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputGroupFile01">
                              </div>
                            </div>
                            <div> <a href="javaScript:void(0)" id="agregar-archivo" class="d-flex mt-2"><i class="lni lni-circle-plus purple fs-4 me-1"></i><p>Agregar otro archivo</p></a> </div>
                            <div class="form-group button d-flex justify-content-end mb-0">
                              <button type="submit" class="btn"> Enviar </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <?php include_once "../extras/utils/newsletter.php" ; ?>
  <?php include_once "../extras/utils/footer.php" ; ?>

  <a href="#" class="scroll-top btn-hover" style="display: none">
    <i class="lni lni-chevron-up"></i>
  </a>

  <script src="../assets/libs/bootstrap/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <script src="../assets/libs/wow/js/wow.min.js"></script>
  <script src="../assets/libs/tinyslider/tiny-slider.js"></script>
	<script src="../assets/libs/glightbox/glightbox.min.js"></script>
  <script src="../assets/js/main.js"></script>

  <script src="../assets/js/dashboard/crearServicios/servicios.js"></script>
</body>

</html>