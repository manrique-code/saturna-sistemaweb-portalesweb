<?php
    require_once "config.php";
    require_once "funciones.php";
    $domain = $_SERVER['SERVER_NAME'];
    $f = new funciones(null, "", $domain);  
    $f->inicio_sesion();

    // cerramos la sesion
    $_SESSION = [];
    $cookieParam = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - (24*60*60*5),
        $cookieParam["path"],
        $cookieParam["domain"],
        $cookieParam["secure"],
        $cookieParam["httponly"]
    );

    session_destroy();
    // esto automaticamente nos lleva a la pantalla de incio despues de cerrar sesion
    header('location: ./index.php');
?>