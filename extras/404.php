<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <title>Error 404 - ClassiGrids Classified Ads and Listing Website Template.</title>
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

  <!-- Preloader -->
  <div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- /End Preloader -->

  <!-- Start Error Area -->
  <div class="error-area">
    <div class="d-table">
      <div class="d-table-cell">
        <div class="container">
          <div class="error-content">
            <h1>404</h1>
            <h2>Here Is Some Problem</h2>
            <p>The page you are looking for it maybe deleted</p>
            <div class="button">
              <a href="index.html" class="btn">Go To Home</a>
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
    }

    function fadeout() {
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    }
  </script>
</body>

</html>