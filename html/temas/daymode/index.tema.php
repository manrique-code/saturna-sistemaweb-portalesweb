<?php
    global $f;
    $currentUserData = $f->usuarioConectado();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, 
    maximum-scale=1.0">
    <!-- iconos del sitio web -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $urlRecursos?>/img/saturnaicon/iconosapple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $urlRecursos?>/img/saturnaicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?php echo $urlRecursos?>/img/saturnaicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?php echo $urlRecursos?>/img/saturnaicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?php echo $urlRecursos?>/img/saturnaicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo $urlRecursos?>/img/saturnaicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?php echo $urlRecursos?>/img/saturnaicon/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="<?php echo $urlRecursos?>/img/saturnaicon/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="<?php echo $urlRecursos?>/img/saturnaicon/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="<?php echo $urlRecursos?>/img/saturnaicon/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="<?php echo $urlRecursos?>/img/saturnaicon/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="<?php echo $urlRecursos?>/img/saturnaicon/mstile-310x310.png" />
    <!-- iconos del sitio web -->
    <link rel="stylesheet" href="<?php echo $urlRecursos?>/css/materialize.css"> 
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo $urlTema?>/css/styles.css">
    <link rel="stylesheet" href="<?php echo "$urlRecursos/js/jqueryui/jquery-ui.css"?>">
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
                <div href="#" id="login-usuario"><?php 
                    // mostrar bien la imagen o el texto de login dependiendo si ha iniciado sesión
                    if ($currentUserData) {
                        $currentUserId = $currentUserData["idusuario"];
                        $serverPath = $_SERVER["DOCUMENT_ROOT"];
                        ?>
                            <img src=<?php
                                if (file_exists("$serverPath/uploads/imagenes_usuarios/$currentUserId.png")) {
                                    echo "$urlSite/uploads/imagenes_usuarios/$currentUserId.png";
                                } else {
                                    echo "$urlSite/uploads/imagenes_usuarios/defaultimage.png";
                                }
                            ?> alt="" id="img-perfil" title=<?php echo $currentUserId;?>>

                        <?php
                    } else { echo "Iniciar sesión";}
                ?></div>
                <?php 
                    if ($f->esAdmin()) {
                        ?>
                        <i class="fas fa-cog optionsButton" id="optionsButton" title="Opciones"></i>
                        <?php
                    }
                ?>
                <!-- <a href=<?php echo "$urlSite/?mod=adminarticulo&accion=crear"?> title="Configuraciones"><i class="fas fa-cog"></i></a> -->
            </nav>
            <div class="icons-nav">
                <a href="#" id="user"><i class="far fa-user-circle user-header"></i></a>
                <i class="fas fa-bars menu-header" id="menu"></i>
            </div>
        </header>

        <div id="logins" class="">
            <?php
                $f->bloque("loginform"); 
            ?>
        </div>

        <div class="seccion">
            <?php $f->modulo($idmodulo);?>
        </div>

<?php 
        if ($currentUserData) {
            if ($f->esAdmin()) {
?>
            <div class="optionsSideBar" id="optionsSideBar">
                <h2 class="optionsHeader">Ajustes de usuario administrador</h2>
                <hr class="optionLoginSeparator">
                <h3 class="optionItemHeader">AJUSTES DE USUARIO</h3>
                <div class="optionItems">
                    <a href="" class="optionItemButton">Administración de usuarios</a>
                </div>
                <hr class="optionLoginSeparator">
                <h3 class="optionItemHeader">AJUSTES DE MENÚS</h3>
                <div class="optionItems">
                    <a href=<?php echo "$urlSite/?mod=adminmenus"; ?> class="optionItemButton">Administración de menús</a>
                </div>
                <hr class="optionLoginSeparator">
                <h3 class="optionItemHeader">AJUSTES DE ARTÍCULOS</h3>
                <div class="optionItems">
                    <a href=<?php echo "$urlSite/?mod=adminarticulos"?> class="optionItemButton">Administración de artículos</a>
                    <a href=<?php echo "$urlSite/?mod=adminarticulo&accion=nuevo"?> class="optionItemButton">Crear artículo</a>
                    <a href=<?php echo "$urlSite/?mod=admincategoriasart"?> class="optionItemButton">Administración de categorías</a>
                </div>
                <hr class="optionLoginSeparator">
                <h3 class="optionItemHeader">AJUSTES DE MÓDULOS</h3>
                <div class="optionItems">
                    <a href=<?php echo "$urlSite/?mod=adminmodulos"?> class="optionItemButton">Administración de módulos</a>
                    <a href=<?php echo "$urlSite/?mod=adminmodulo&accion=nuevo"?> class="optionItemButton">Crear módulo</a>
                </div>
            </div>
<?php
             }
        } 
?>
    </div>
    <footer>
            <div class="social-media">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="autor">Sergio Manrique Rios Reyes</p>
        </footer>
        

    <script src="<?php echo $urlTema?>/js/scripts.js"></script>
    <script src="<?php echo $urlRecursos?>/js/jquery.min.js"></script>
</body>
</html>