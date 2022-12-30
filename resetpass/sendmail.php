<!doctype html>
<html lang="en">
  <head>
  	<title>Recuperar Contraseña</title>
	<?php include "../extras/utils/head.php" ?>
    
	</head>
	
	<body  style="background-color: #d7d1ef;">
		<div class="background overlay blur"></div>
        
	<section class="login section" >
		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 shadow p-md-5">
		      	        <div class="icon d-flex align-items-center  justify-content-center" style="background-color: #5830E0;">
		      		        <span class="fa fa-envelope-o"></span>
		      	        </div>
		      	        <h4 class="text-center mb-4">Ingrese su dirección de correo electrónico</h4>
                        <p class="mb-2" >Para recuperar su contraseña, por favor ingrese a continuación la dirección de correo electrónico asociada a su cuenta.</p>
				        <form action="#" class="login-form">
		      		        <div class="form-group">
		      			        <input type="email" class="mb-4 form-control rounded-left" placeholder="Correo Electrónico" required>
		      		        </div>
				            <div class="form-group">
                                <div class="button submit">
                                    <button type="submit" class="btn submit" style="top: 45px" _msthash="2657317" _msttexthash="115427">Enviar</button>
                                </div>
	                        </div>
                            <div class="form-group d-md-flex">
					            <div class=" text-md-center ">
                                    <a href="#" style="color: #5830E0;">Regresar a iniciar sesión</a>
                                </div>
				            </div>
	                    </form>
	                </div>
				</div>
			</div>
		</div>
	</section>

    <?php include "../extras/utils/scripts.php" ?>
	<script src="../assets/js/recuperarClave/validarEnvioEmail.js"></script>
	</body>
</html>