<?php
    // toma valor que está dentro del config.
    // esto es super util porque podemos modularizar.
    // php se programa y se utiliza donde se necesita nada más
    // se programa por bloques como este de aquí.
    // este es un ambito de php donde todas las variables y funciones pueden ser llamadas
    require_once "config.php";
    require_once "funciones.php";

    // asi vamos a saber que protocolo estamos utilizando con PHP
    $protocolo = "http://";

    // es una variable de entorno que nos da informacion sobre el sevidor y donde la estamos ejecutando
    // hay dos tipos de arreglos, arreglos con nombres (diccionarios) y arreglos con indices (como los normales)
    $server_name = $_SERVER['SERVER_NAME'];

    // la url de nuestro sitio
    // punto para concatenar las cadenas de texto
    $urlSite = $protocolo . $server_name;

    // la url de los recursos
    $urlRecursos = "$urlSite/res";

    // la url de los temas
    $urlTema = "$urlSite/temas/$tema";

    // toma las variables que le pasamos desde la URI de nuestro sitio web
    $idmodulo = isset($_GET["mod"]) ? $_GET["mod"] : 'inicio';

    // creamos una instancia para la conexion a la base de datos
    $mysqli = new mysqli(
        $mysql_server,
        $mysql_user,
        $mysql_psw,
        $mysql_db 
    );

    if ($mysqli->connect_errno) {
        echo "Fallón la conexión a MySQL: (". $mysqli-> connect_errno . ") " . $myqsli->connect_errno;
    } else {
        $f = new funciones($mysqli, $urlSite);
        // aqui estamso requiriendo el tema de nuestra página y es el tema que el servidor va a renderizar
        require "temas/$tema/index.normalmode.php";
    }

    $mysqli->close();
    
?>

