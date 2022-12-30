<html class="no-js" lang="zxx">
  <head>
    <title>
      Contactanos - ClassiGrids Classified Ads and Listing Website Template
    </title>
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

    <!--aqui va el header-->
    <?php include_once "utils/header.php" ?>
    <!--aqui el breadcrumbs-->
    <?php include_once "utils/breadcrumbs.php" ?>

    

    <!--inicio: formulario de contactos-->
    <section id="contact-us" class="contact-us section">
      <div class="container">
        <div
          class="contact-head wow fadeInUp"
          data-wow-delay=".4s"
          style="
            visibility: visible;
            animation-delay: 0.4s;
            animation-name: fadeInUp;
          "
        >
          <div class="row">
            <div class="col-lg-5 col-12">
              <div class="single-head">
                <div class="contant-inner-title">
                  <h2>Nuestros Contactos &amp; Ubicación</h2>
                  <p>
                    Business consulting excepteur sint occaecat cupidatat
                    consulting non proident.
                  </p>
                </div>
                <div class="single-info">
                  <h3>Horario</h3>
                  <ul>
                    <li>Diario: 9.30 AM–6.00 PM</li>
                    <li>Domingo &amp; Festivos: Cerrado</li>
                  </ul>
                </div>
                <div class="single-info">
                  <h3>Información de contacto</h3>
                  <ul>
                    <li>77408 Satterfield Motorway Suite</li>
                    <li>469 New Antonetta, BC K3L6P6</li>
                    <li>
                      <a href="mailto:info@yourwebsite.com">example@info.com</a>
                    </li>
                    <li>
                      <a href="tel:(617) 495-9400-326">(617) 495-9400-326</a>
                    </li>
                  </ul>
                </div>
                <div class="single-info contact-social">
                  <h3>Contacto social</h3>
                  <ul>
                    <li>
                      <a href="javascript:void(0)"
                        ><i class="lni lni-facebook-original"></i
                      ></a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"
                        ><i class="lni lni-twitter-original"></i
                      ></a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"
                        ><i class="lni lni-linkedin-original"></i
                      ></a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"
                        ><i class="lni lni-pinterest"></i
                      ></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-12">
              <div class="form-main">
                <div class="form-title">
                  <h2>Contáctanos</h2>
                  <p>
                    There are many variations of passages of Lorem Ipsum
                    available, but the majority have suffered alteration in some
                    form.
                  </p>
                </div>
                <form class="form" method="post" action="assets/mail/mail.php">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <input
                          name="name"
                          type="text"
                          placeholder="Nombre"
                          required="required"
                        />
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <input
                          name="subject"
                          type="text"
                          placeholder="Su tema"
                          required="required"
                        />
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <input
                          name="email"
                          type="email"
                          placeholder="Correo Electronico"
                          required="required"
                        />
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <input
                          name="phone"
                          type="text"
                          placeholder="Telefono"
                          required="required"
                        />
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group message">
                        <textarea
                          name="message"
                          placeholder="Mensaje"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group button">
                        <button type="submit" class="btn">
                          Enviar mensaje
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--fin: formulario de contactos-->

    
    <!--inicio: ubicacion google-->
    <div class="map-section">
      <div class="map-container">
        <div class="mapouter">
          <div class="gmap_canvas">
            <iframe
              width="100%"
              height="500"
              id="gmap_canvas"
              src="https://maps.google.com/maps?q=New%20York&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
              frameborder="0"
              scrolling="no"
              marginheight="0"
              marginwidth="0"
            ></iframe
            ><a href="https://123movies-to.com">123movies old site</a>
            <style>
              .mapouter {
                position: relative;
                text-align: right;
                height: 500px;
                width: 100%;
              }

              .gmap_canvas {
                overflow: hidden;
                background: none !important;
                height: 500px;
                width: 100%;
              }
            </style>
          </div>
        </div>
      </div>
    </div>
    <!--fin: ubicacion google-->

    <!--franja de conctato-->
    <?php include_once "utils/newsletter.php" ?>
    <!--aqui va el footer-->
    <?php include_once "utils/footer.php" ?>

    

    <a href="#" class="scroll-top btn-hover" style="display: flex">
      <i class="lni lni-chevron-up"></i>
    </a>

    <?php include "../extras/utils/scripts.php" ?>
  </body>
</html>
