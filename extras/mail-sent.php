<html class="no-js" lang="zxx">
  <head>
    <title>
      Mail Success - ClassiGrids Classified Ads and Listing Website Template.
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

    <div class="maill-success">
      <div class="d-table">
        <div class="d-table-cell">
          <div class="container">
            <div class="success-content">
              <h1>Felicidades!</h1>
              <h2>Su correo enviado correctamente</h2>
              <p>
                Gracias por ponerse en contacto con nosotros, nos pondremos en contacto con usted lo antes posible.
              </p>
              <div class="button">
                <a href="index.html" class="btn">incio</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "../extras/utils/scripts.php" ?>
    <script>
      window.onload = function () {
        window.setTimeout(fadeout, 500);
      };

      function fadeout() {
        document.querySelector(".preloader").style.opacity = "0";
        document.querySelector(".preloader").style.display = "none";
      }
    </script>
  </body>
</html>
