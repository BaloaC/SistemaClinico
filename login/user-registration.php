<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="../assets/css/preloader.css">
</head>

<body style="background-color: #d7d1ef;">

    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <section class="login registration section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                    <div class="form-head login-wrap">
                        <div class="icon d-flex align-items-center  justify-content-center" style="background-color: #5830E0;">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h4 class="title">Crear una cuenta</h4>
                        <form action="#" method="post" class="login-form" id="form-registro">
                                <div class="d-none" id="mensaje-error"></div>

                                <div class="form-group">
                                    <label>Nombre Completo</label>
                                    <input id="nombreCompleto" class="form-control rounded-left" name="nombre_completo" type="text" required>
                                    <div id="mensaje-nombre-completo" class="invalid-feedback "></div>
                                </div>

                                <div class="form-group">
                                    <label>Nombre de usuario</label>
                                    <input id="nombreUsuario" name="nombre_usuario" class="form-control rounded-left" type="text" required>
                                    <div id="mensaje-nombre-usuario" class="invalid-feedback "></div>
                                </div>

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input id="clave" name="clave" class="form-control rounded-left" type="password" required>
                                    <div id="mensaje-clave" class="invalid-feedback "></div>
                                </div>

                                <div class="form-group">
                                    <label>Confirmar Contraseña</label>
                                    <input name="confirmar_clave" class="form-control rounded-left" id="claveRepetida" type="password" required>
                                    <div id="mensaje-clave-repetida" class="invalid-feedback "></div>
                                </div>

                                <div class="form-group">
                                    <label>Correo Electrónico</label>
                                    <input id="correoElectronico" class="form-control rounded-left" name="correo_electronico" type="email" required>
                                    <div id="mensaje-correo" class="invalid-feedback "></div>
                                </div>

                                <div class="check-and-pass">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input width-auto" name="condServi" id="aceptarCondiciones">
                                                <label class="form-check-label">Acepta nuestros <a href="javascript:void(0)">Términos y
                                                    Condiciones del Servicio</a></label>
                                                    <div id="mensaje-aceptar-condiciones" class="invalid-feedback "></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="button">
                                    <button type="submit" class="btn">Registrar</button>
                                </div>
                                <p class="outer-link">¿Ya tienes una cuenta? <a href="login.php"> Inicia Sesión</a>
                                </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="../utils/scripts.js"></script>
    <script src="../utils/head.js"></script>
    <script src="../assets/js/login/validarRegistro.js"></script>
</body>

</html>