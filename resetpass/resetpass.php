<!doctype html>
<html lang="en">
  <head>
  	<title>Recuperar Contraseña</title>
	  <?php include "../extras/utils/head.php" ?>
    
	</head>
	
	<body  style="background-color: #d7d1ef;">
		<div class="background overlay blur"></div>
	<section class="login section ">
		<div class="container">
			<div class="row justify-content-center ">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 shadow p-md-5">
		      	        <div class="icon d-flex align-items-center  justify-content-center" style="background-color: #5830E0;">
		      		        <span class="fa fa-unlock-alt"></span>
		      	        </div>
		      	        <h4 class="text-center mb-4">Ingrese su nueva contraseña</h4>
                        <p class="mb-2" >Ingrese la nueva contraseña que usará para iniciar sesión.</p>
				        <form action="#" class="login-form">
		      		        <div class="form-group">
								<label>Nueva contraseña</label>
		      			        <input type="password" class="mb-2 form-control rounded-left" placeholder="" required>
		      		        </div>
                              <div class="form-group">
								<label>Repita la contraseña</label>
                                <input type="password" class="mb-4 form-control rounded-left" placeholder="" required>
                            </div>
				            <div class="form-group">
                                <div class="button submit">
                                    <button type="submit" class="btn submit" style="top: 45px" _msthash="2657317" _msttexthash="115427">Enviar</button>
                                </div>
	                        </div>
                            <div class="form-group d-md-flex">
					            <div class=" text-md-center ">
                                    <a href="#" style="color: #5830E0;">Regresar a inicio</a>
                                </div>
				            </div>
	                    </form>
	                </div>
				</div>
			</div>
		</div>
	</section>

    <?php include "../extras/utils/scripts.php" ?>

	</body>
</html>