<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
    maximum-scale=1.0">
    <link rel="stylesheet" href="<?php echo $urlRecursos?>/css/materialize.css"> 
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/styles.css">
    <title>Saturna</title>
</head>
<body>    
    <div class="contenedor">

        <!-- barra de navegacion -->
        <header class="header">
            <div class="logo">
                <a href=<?php echo $urlSite?>><div class="imagen-logo"></div></a>
            </div>
            <nav class="">
                <a href="#" class="seleccionado">Inicio</a>
                <a href="#">Tecnología</a>
                <a href="#">Cine</a>
                <a href="#">Cursos</a>
                <a href="#">About us</a>
                <a href="#" id="login-usuario">Login</a>
                <a href=<?php echo "$urlSite/?mod=perfilusuario"?> title="Configuraciones"><i class="fas fa-cog"></i></a>
            </nav>
            <div class="icons-nav">
                <a href="#" id="user"><i class="far fa-user-circle user-header"></i></a>
                <i class="fas fa-bars menu-header" id="menu"></i>
            </div>
        </header>

        <div id="logins" class="active">
            <?php
                $f->bloque("loginform"); 
            ?>
        </div>

        <div class="seccion">
            <?php $f->modulo($idmodulo);?>
        </div>

        

        <footer>
            <div class="social-media">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="autor">Sergio Manrique Rios Reyes</p>
        </footer>

    </div>
        

    <script src="<?php echo $urlTema?>/js/scripts.js"></script>
    <script src="<?php echo $urlRecursos?>/js/jquery.min.js"></script>
</body>
</html>