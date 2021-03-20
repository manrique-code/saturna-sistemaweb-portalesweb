<?php
    require_once "config.php";
    require_once "funciones.php";
    $protocolo = "http://"; //Pendiente de verificar si es HTTPS
    $urlSite = $protocolo . $_SERVER['SERVER_NAME'];
    $domain = $_SERVER['SERVER_NAME'];
    $urlRecursos = "$urlSite/recursos";
    $urlTema = "$urlSite/temas/$tema";
       
    $idmodulo = isset($_GET["mod"]) ? $_GET["mod"] : 'inicio';
    $mysqli = new mysqli($mysql_svr, $mysql_usr, $mysql_psw, $mysql_db);
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    else{
        $f = new funciones($mysqli, $urlSite, $domain);  
        $f->inicio_sesion();
        require "temas/$tema/index.tema.php";  
    }
    $mysqli->close();
?>