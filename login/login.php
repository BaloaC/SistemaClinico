<!doctype html>
<html lang="en">

<head>
	<title>Inicio</title>
	<link rel="stylesheet" href="../assets/css/preloader.css">
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

	<section class="login section">
		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-md-6 col-lg-5">
					<div class="form-head login-wrap p-4 p-md-5" id="manejador">
						<div class="icon d-flex align-items-center  justify-content-center" style="background-color: #5830E0;">
							<span class="fa fa-user-o"></span>
						</div>
						<!--errores-->
						<h4 class="title">Inicio de Sesión</h4>
						<div class="alert alert-danger d-none" id='mensaje-error-logueo' role="alert">
							No se pudo validar la identidad del usuario
						</div>
						<div class="alert alert-danger d-none" id='mensaje-error-servidor' role="alert">
							No se puede procesar su peticion en estos momentos
						</div>

						<form action="#" class="login-form" id="form-login">

							<div class="d-none" id="mensaje-error">
							</div>

							<div class="form-group">
								<label> Nombre de usuario</label>
								<input type="text" id="login-name" name="nombre_usuario" class="mb-2 rounded-left" placeholder="" required>
							</div>
							<div class="form-group">
								<label> Contraseña</label>
								<input type="password" id="login-pass" name="clave" class=" rounded-left" placeholder="" required>
							</div>

							<div class="text-md-left mb-20">
								<a href="#" style="color: #5830E0;" class="lost-pass">¿Perdiste tu contraseña?</a>
								<p id="mensaje-login"></p>
							</div>

							<div class="form-group">
								<div class="button submit" id="boton">
									<button type="submit" class="btn submit" _msthash="2657317" _msttexthash="115427" id="btnLogin">Enviar</button>
								</div>
							</div>
							
							<div class=" text-md-center md-5">
								¿Todavía no tienes una cuenta? <a href="user-registration.php" style="color: #5830E0;"> Regístrate</a>
							</div>

						</form>
					</div>
				</div>
			</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
	<script src="../utils/head.js"></script>
	<script src="../utils/scripts.js"></script>
	<script src="../assets/js/login/validarLogueo.js"></script>
</body>

</html>