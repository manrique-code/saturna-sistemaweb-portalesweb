<?php
    // toma valor que está dentro del config.
    // esto es super util porque podemos modularizar.
    // php se programa y se utiliza donde se necesita nada más
    // se programa por bloques como este de aquí.
    // este es un ambito de php donde todas las variables y funciones pueden ser llamadas
    require "config.php";

    // asi vamos a saber que protocolo estamos utilizando con PHP
    $protocolo = "http://";

    // es una variable de entorno que nos da informacion sobre el sevidor y donde la estamos ejecutando
    // hay dos tipos de arreglos, arreglos con nombres (diccionarios) y arreglos con indices (como los normales)
    $server_name = $_SERVER['SERVER_NAME'];

    // la url de nuestro sitio
    $urlSite = $protocolo . $server_name;

    // la url de los recursos
    $urlRecursos = "$urlSite/res";

    // la url de los temas
    $urlTema = "$urlSite/temas/$tema";

    // aqui estamso requiriendo el tema de nuestra página y es el tema que el servidor va a renderizar
    require "temas/$tema/index.normalmode.php";
    
    echo $urlSite;
?>

