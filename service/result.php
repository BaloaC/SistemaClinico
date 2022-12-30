<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ad Listing Grid - ClassiGrids Classified Ads and Listing Website Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.svg">


    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/libs/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="../assets/libs/Linelcons/LineIcons.2.0.css" />
	<link rel="stylesheet" href="../assets/libs/animate/animate.css" />
	<link rel="stylesheet" href="../assets/libs/tinyslider/tiny-slider.css" />
	<link rel="stylesheet" href="../assets/libs/glightbox/glightbox.min.css" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>
    <!--[if lte IE 9]>
          <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please
            <a href="https://browsehappy.com/">upgrade your browser</a> to improve
            your experience and security.
          </p>
        <![endif]-->

    <div class="preloader" style="opacity: 0; display: none;">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <?php include_once "../extras/utils/header.php"; ?>
    <?php include_once "../extras/utils/breadcrumbs.php"; ?>

    <section class="category-page section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="category-sidebar">

                        <div class="single-widget search">
                            <h3>Buscar Anuncios</h3>
                            <form action="#">
                                <input type="text" placeholder="Buscar...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>


                        <div class="single-widget">
                            <h3>Todas las categorías</h3>
                            <ul class="list">
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-dinner"></i> Turismo<span>15</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-control-panel"></i> Servicios <span>20</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-bullhorn"></i> Marketing <span>55</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-home"></i> Inmuebles<span>35</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-bolt"></i> Electrónicos <span>60</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-tshirt"></i> Ropa<span>55</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><i class="lni lni-diamond-alt"></i> Joyería y Accesorios
                                        <span>45</span></a>
                                </li>
                            </ul>
                        </div>


                        <div class="single-widget range">
                            <h3>Rango de Precios</h3>
                            <input type="range" class="form-range" name="range" step="1" min="100" max="10000" value="10" onchange="rangePrimary.value=value">
                            <div class="range-inner">
                                <label>$</label>
                                <input type="text" id="rangePrimary" placeholder="100">
                            </div>
                        </div>


                        <div class="single-widget condition">
                            <h3>Condición</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Todos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                <label class="form-check-label" for="flexCheckDefault2">
                                    Nuevos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                <label class="form-check-label" for="flexCheckDefault3">
                                    Usados
                                </label>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="category-grid-list">
                        <div class="row">
                            <div class="col-12">
                                <div class="category-grid-topbar">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <h3 class="title">Mostrando 1-12 de 21 anuncios encontrados</h3>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true"><i class="lni lni-grid-alt"></i></button>
                                                    <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false"><i class="lni lni-list"></i></button>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Sale</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Teléfono</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Apple Iphone X</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Caracas</a></p>
                                                        <ul class="info">
                                                            <li class="price">$890.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Venta</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Otros</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Kit de viaje</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>San Francisco</a></p>
                                                        <ul class="info">
                                                            <li class="price">$580.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Venta</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Electronicos</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Nikon DSLR Camera</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Miami, USA</a></p>
                                                        <ul class="info">
                                                            <li class="price">$560.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Venta</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Mueblería</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Pintura</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Maracaibo</a></p>
                                                        <ul class="info">
                                                            <li class="price">$85.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Vena</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Mueblería</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Silla de Reuniones</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Valencia</a></p>
                                                        <ul class="info">
                                                            <li class="price">$750.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge rent">Renta</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Libros y Revistas</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Libro de Cuentos</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>New York, USA</a></p>
                                                        <ul class="info">
                                                            <li class="price">$120.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Venta</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Electronicos</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Cctv camera</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Delhi, India</a></p>
                                                        <ul class="info">
                                                            <li class="price">$350.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Sale</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Mobile</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Apple Iphone X</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Boston</a></p>
                                                        <ul class="info">
                                                            <li class="price">$890.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12">

                                                <div class="single-item-grid">
                                                    <div class="image">
                                                        <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                        <i class=" cross-badge lni lni-bolt"></i>
                                                        <span class="flat-badge sale">Sale</span>
                                                    </div>
                                                    <div class="content">
                                                        <a href="javascript:void(0)" class="tag">Mobile</a>
                                                        <h3 class="title">
                                                            <a href="../item-details.html">Samsung Glalaxy S8</a>
                                                        </h3>
                                                        <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                </i>Delaware, USA</a></p>
                                                        <ul class="info">
                                                            <li class="price">$299.00</li>
                                                            <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">

                                                <div class="pagination left">
                                                    <ul class="pagination-list">
                                                        <li><a href="javascript:void(0)">1</a></li>
                                                        <li class="active"><a href="javascript:void(0)">2</a></li>
                                                        <li><a href="javascript:void(0)">3</a></li>
                                                        <li><a href="javascript:void(0)">4</a></li>
                                                        <li><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-12">

                                                <div class="single-item-grid">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-5 col-md-7 col-12">
                                                            <div class="image">
                                                                <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                                <i class=" cross-badge lni lni-bolt"></i>
                                                                <span class="flat-badge sale">Sale</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7 col-md-5 col-12">
                                                            <div class="content">
                                                                <a href="javascript:void(0)" class="tag">Others</a>
                                                                <h3 class="title">
                                                                    <a href="../item-details.html">Travel Kit</a>
                                                                </h3>
                                                                <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                        </i>San Francisco</a></p>
                                                                <ul class="info">
                                                                    <li class="price">$580.00</li>
                                                                    <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">

                                                <div class="single-item-grid">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-5 col-md-7 col-12">
                                                            <div class="image">
                                                                <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                                <i class=" cross-badge lni lni-bolt"></i>
                                                                <span class="flat-badge sale">Sale</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7 col-md-5 col-12">
                                                            <div class="content">
                                                                <a href="javascript:void(0)" class="tag">Electronic</a>
                                                                <h3 class="title">
                                                                    <a href="../item-details.html">Nikon DSLR Camera</a>
                                                                </h3>
                                                                <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                        </i>Alaska, USA</a></p>
                                                                <ul class="info">
                                                                    <li class="price">$560.00</li>
                                                                    <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">

                                                <div class="single-item-grid">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-5 col-md-7 col-12">
                                                            <div class="image">
                                                                <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                                <i class=" cross-badge lni lni-bolt"></i>
                                                                <span class="flat-badge sale">Sale</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7 col-md-5 col-12">
                                                            <div class="content">
                                                                <a href="javascript:void(0)" class="tag">Mobile</a>
                                                                <h3 class="title">
                                                                    <a href="../item-details.html">Apple Iphone X</a>
                                                                </h3>
                                                                <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                        </i>Boston</a></p>
                                                                <ul class="info">
                                                                    <li class="price">$890.00</li>
                                                                    <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">

                                                <div class="single-item-grid">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-5 col-md-7 col-12">
                                                            <div class="image">
                                                                <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                                <i class=" cross-badge lni lni-bolt"></i>
                                                                <span class="flat-badge sale">Sale</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7 col-md-5 col-12">
                                                            <div class="content">
                                                                <a href="javascript:void(0)" class="tag">Furniture</a>
                                                                <h3 class="title">
                                                                    <a href="../item-details.html">Poster Paint</a>
                                                                </h3>
                                                                <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                        </i>Las Vegas</a></p>
                                                                <ul class="info">
                                                                    <li class="price">$85.00</li>
                                                                    <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">

                                                <div class="single-item-grid">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-5 col-md-7 col-12">
                                                            <div class="image">
                                                                <a href="../item-details.html"><img src="../assets/images/items-tab/item-1.jpg" alt="#"></a>
                                                                <i class=" cross-badge lni lni-bolt"></i>
                                                                <span class="flat-badge rent">Rent</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-7 col-md-5 col-12">
                                                            <div class="content">
                                                                <a href="javascript:void(0)" class="tag">Books &amp; Magazine</a>
                                                                <h3 class="title">
                                                                    <a href="../item-details.html">Story Book</a>
                                                                </h3>
                                                                <p class="location"><a href="javascript:void(0)"><i class="lni lni-map-marker">
                                                                        </i>New York, USA</a></p>
                                                                <ul class="info">
                                                                    <li class="price">$120.00</li>
                                                                    <li class="like"><a href="javascript:void(0)"><i class="lni lni-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">

                                                <div class="pagination left">
                                                    <ul class="pagination-list">
                                                        <li><a href="javascript:void(0)">1</a></li>
                                                        <li class="active"><a href="javascript:void(0)">2</a></li>
                                                        <li><a href="javascript:void(0)">3</a></li>
                                                        <li><a href="javascript:void(0)">4</a></li>
                                                        <li><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
                                                    </ul>
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
        </div>
    </section>

    <?php include_once "../extras/utils/newsletter.php"; ?>
    <?php include_once "../extras/utils/footer.php"; ?>


    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="../assets/libs/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/libs/wow/js/wow.min.js"></script>
    <script src="../assets/libs/tinyslider/tiny-slider.js"></script>
	<script src="../assets/libs/glightbox/glightbox.min.js"></script>
    <script src="../assets/js/main.js"></script>

</body>

</html>