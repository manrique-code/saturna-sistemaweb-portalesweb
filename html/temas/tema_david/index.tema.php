<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es_HN" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<link href="<?php echo $urlRecursos?>/css/materialicons.css" rel="stylesheet" type="text/css" />
		<link type="text/css" rel="stylesheet" href="<?php echo $urlRecursos?>/css/materialize.css"  media="screen,projection" />
		<link type="text/css" rel="stylesheet" href="<?php echo $urlTema?>/css/custom.css" />
		<title>Portales Web 2</title>
	</head>
	<body class="blue-grey darken-3" text="white">	
		<script type="text/javascript" src="<?php echo $urlRecursos?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $urlRecursos?>/js/materialize.min.js"></script>
		<script type="text/javascript" src="<?php echo $urlTema?>/js/custom.js"></script>

		<div class="" style="position: relative !important;"> 
			<nav id="topBar" class="blue-grey darken-4">
				<div class="nav-wrapper container ">
					<a href="#" data-target="menuDesplegable" class="sidenav-trigger">
						<i class="material-icons">menu</i>
					</a>
					<ul class="left hide-on-med-and-down">
						<li class="activo"><a class="white-text" href="#">INICIO</a></li>
						<li><a class="white-text" href="#">SERVICIOS</a></li>
						<li><a class="white-text"href="#">PROYECTOS</a></li>
						<li><a class="white-text"href="#">CLASES</a></li>
						<li><a class="white-text"href="#">DISEÑO</a></li>
						<li><a class="white-text"href="#">CONTACTO</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<ul class="sidenav" id="menuDesplegable">
			<li class="activo"><a href="#">INICIO</a></li>
			<li><a href="#">SERVICIOS</a></li>
			<li><a href="#">PROYECTOS</a></li>
			<li><a href="#">CLASES</a></li>
			<li><a href="#">DISEÑO</a></li>
			<li><a href="#">CONTACTO</a></li>
		</ul>
		<div>
			<div class="row  blue-grey darken-3" style="margin-bottom: 0px;">
				<div class="row  blue-grey darken-3 row70" id="row1">
					<div class="col s12 l5">
						<img src="<?php echo $urlTema?>/img/smitelogo.png" class="responsive-img">
						<p class="white-text pcamaleon">SMITE es un videojuego de acción MOBA en tercera persona, creado y publicado por Hi-Rez 
							Studios para Microsoft Windows, Xbox One,PlayStation 4 y Nintendo Switch. El juego se basa en dos equipos, cada uno 
							formado por cinco dioses, enfrentados en un campo de batalla con la finalidad de destruir el titán enemigo situado 
							en cada una de las bases.
						</p>
					</div>
					<div class="col s12 l7">
						<div class="responsive-container" style="margin-top: 8px;">
							<div class="sliderPW camaleones">
								<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/img1.jpg"/></a>
								<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/img2.jpg"/></a>
								<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/img3.jpg"/></a>
								<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/img4.jpg"/></a>
								<a class="slide" href="#"><img src="<?php echo $urlTema?>/img/img5.jpg"/></a>
							</div>
						</div>
					</div>
	
				</div>
				<div class="row blue-grey darken-4" style="margin-bottom: 0px;">
					<div class="row70">
						<div class="row center" style="padding-top: 100px; box-shadow: 0px 60px 31px -54px rgba(0,0,0,0.2);">
							<h6 style="font-weight: bold;">Welcome to Smite</h6>
							<p>Cada jugador se pone en la piel de un dios de diferentes mitologías el cual posee distintos poderes y 
								características. En el campo de batalla también se pueden encontrar personajes no controlados (súbditos) 
								que proporcionan oro y experiencia.
							</p>
						</div>
						<div class="row">
							<div class="col s12 l1">								
								<img src="<?php echo $urlTema?>/img/game.png" style="margin-top: 30px;" height="100px">
							</div>
							<div class="col s12 l7">
								<h4>Elige a tu Dios</h4>								
								<p style="text-align: justify;"> Con una lista en constante expansión de más de 100 dioses que abarcan numerosos panteones de todo el mundo, queremos que te sientas 
									capacitado para dominar el campo de batalla con un conjunto único de personajes jugables. ¿Tienes curiosidad por ver qué dios combina 
									con tu estilo de juego? ¡Clic aquí para saber más!
									<ul>
										<li><a href="https://www.smitegame.com/game-modes/">Conquista</a></li>
										<li><a href="https://www.smitegame.com/game-modes/">Arena</a></li>
										<li><a href="https://www.smitegame.com/game-modes/">Cerco</a></li>
										<li><a href="https://www.smitegame.com/game-modes/">Justar</a></li>
									</ul>
								</p>
							</div>
							<div class="col s12 l4">
								<h4>Articulos</h4>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/articulo.png" style="float: left;width: 80px;height: 80px;">Los artículos son objetos y artefactos que brindan beneficios y / o habilidades específicas a un 
									dios más allá de sus capacidades básicas.
								</p>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/reliquia.png" style="float: left;width: 80px;height: 80px;">Las reliquias otorgan al jugador nuevas habilidades, como volverse invulnerable durante un corto 
									período de tiempo.
								</p>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/consumible.png" style="float: left;width: 80px;height: 80px;">Los consumibles son elementos de un solo uso que se eliminan después de activarse.
								</p>
							</div>
						</div>
						<div class="row" >
							<div class="col s12 l4">
								<h5>Modos de juego</h5>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/bloque1.png" style="width: 100px;float: left;height: 113px;">Hay varios modos de juego diversos disponibles en SMITE para ayudar a adaptarse a las preferencias individuales de todos, 
									¡así que echa un vistazo a cada uno de los diferentes modos.</p>
							</div>
							<div class="col s12 l4">
								<h5>Domina los conceptos básicos</h5>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/bloque2.png" style="width: 100px;float: left;height: 113px;">¡Controla todas las mecánicas del juego, como habilidades, objetos y nuestro sistema de comunicación, para ayudar
									a llevar a tu equipo a la victoria! ¡Haga clic aquí para aprender los conceptos básicos!
								</p>
							</div>
							<div class="col s12 l4">
								<h5>Únete a nuestra comunidad</h5>
								<p style="text-align: justify;">
									<img src="<?php echo $urlTema?>/img/bloque3.png" style="width: 100px;float: left;height: 113px;">Manténgase informado sobre todo lo relacionado con SMITE cuando se involucre con el resto de nuestra comunidad más información 
									sobre cómo unirse a nuestra increíble comunidad.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="blue-grey darken-2" style="padding-bottom: 0px;padding-top: 0px;margin-top: 0px;">
			<div class="row container" style="margin-bottom: 0px;"> 
				<div class="col s12 l6 white-text">
					<p></p>
				</div>
				<div class="col s12 l6 white-text right-align">
					<p>©2021 Portales Web Honduras. Todos los derechos reservados</p>
				</div>
			</div>
		</footer>
	</body>
</html>
