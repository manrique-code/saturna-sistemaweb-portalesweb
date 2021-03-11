<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es_HN" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<link href="<?php echo $urlRecursos?>/css/materialicons.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $urlRecursos?>/css/fontawesome.min.css" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="stylesheet" href="<?php echo $urlRecursos?>/css/materialize.css"  media="screen,projection" />
		<link type="text/css" rel="stylesheet" href="<?php echo $urlTema?>/css/custom.css" />
		<title>Portales Web 2</title>
	</head>
	<body>	
		<script type="text/javascript" src="<?php echo $urlRecursos?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $urlRecursos?>/js/materialize.min.js"></script>
		<script type="text/javascript" src="<?php echo $urlTema?>/js/custom.js"></script>

		<!-- Empieza el diseño -->
		
		<!-- Barra Superior -->
		<div class="navbar-fixed">
			<nav id="topBar">
				<div class="nav-wrapper container">
					<a href="./index.html" class="brand-logo">Portales Web</a>
					<a href="#" data-target="menuDesplegable" class="sidenav-trigger">
						<i class="material-icons">menu</i>
					</a>
					<ul class="right hide-on-med-and-down">
						<li><a href="#">Inicio</a></li>
						<li><a href="#">Contenido</a></li>
						<li><a href="#">Articulos</a></li>
						<li><a href="#">Tareas</a></li>
						<li><a href="#">Ejercicios</a></li>
						<li><a href="#">Acerca De</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<ul class="sidenav" id="menuDesplegable">
			<li><a href="#">Inicio</a></li>
			<li><a href="#">Contenido</a></li>
			<li><a href="#">Articulos</a></li>
			<li><a href="#">Tareas</a></li>
			<li><a href="#">Ejercicios</a></li>
			<li><a href="#">Acerca De</a></li>
		</ul>
		<!-- Fin Barra Superior -->

		<!-- slider -->
		<div class="container" style="margin-top: 8px;">
			<div class="sliderPW">
				<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/slider1.jpeg"/></a>
				<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/slider2.jpeg"/></a>
				<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/slider3.jpeg"/></a>
				<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/slider4.jpeg"/></a>
				<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/slider5.jpeg"/></a>
			</div>
		</div>
		<!-- Fin slider -->

		<!-- Contenido -->
		<div class="container white z-depth-3" id="contenido">
			<div class="row">
				<div class="col s12 l3">
					
					<div class="bloque">
						<h2>Log-In</h2>
						<form class="contenido" action="./login.php" method="post">
							<input name="idusuario" type="text" placeholder="Usuario o Email">

							<input name="password" type="password" placeholder="Contraseña">

							
							<button class="btn blue waves-effect waves-light" type="submit" name="action">Submit
								<i class="material-icons right">send</i>
							</button>
        
						</form>
					</div>
					
					<div class="bloque">
						<h2>Siguenos</h2>
						<div class="contenido">
							<p class="center">
								<img src="<?php echo $urlTema?>/img/fb_icon.png" />
								<img src="<?php echo $urlTema?>/img/twitter_Icon.png" />
							</p>
						</div>
					</div>

					<div class="bloque">
						<h2>Imagen Aleatoria</h2>
						<div class="contenido">
							<p class="center">
								<img class="responsive-img" src="<?php echo $urlTema?>/img/aleat.png" />
							</p>
						</div>
					</div>

				</div>
				<div id="contenidoModulo" class="col s12 l9">
					<?php $f->modulo($idmodulo) ;?>
				</div>
			</div>
		</div>
		<!-- FinContenido -->
		<!-- Pie de Pagina -->
		<footer class="black">
			<div class="row container">
				<div class="col s12 l6 white-text">
					<p>©2021 Portales Web Honduras. Todos los derechos reservados</p>
				</div>
				<div class="col s12 l6 white-text right-align">
					<p>Diseño por iSoriano</p>
				</div>
			</div>
		</footer>


		<!-- Fin Pie de Pagina -->
	</body>
</html>
