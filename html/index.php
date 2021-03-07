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
    $idusuario = isset($_GET["idusuario"]) ? $_GET["idusuario"] : '';

    // aqui estamso requiriendo el tema de nuestra página y es el tema que el servidor va a renderizar
    // include "temas/$tema/index.normalmode.php";

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
        $f = new funciones($mysqli);
        $strSql = "SELECT idusuario, nombre from usuarios WHERE idusuario = ?";

        $QueryData = $f->getQueryData($strSql);
        var_dump($QueryData);
        // la conexión a la db se pudo hacer de manera correcta en este punto
        // los queries en el ambiente web no se deben concatenar, en cambio se deben parametrizar
        // porque si concatenamos damos lugar a sqlinjections de los datos.

        // // revisamos si la consulta tiene algun error de sintaxis
        // if ($stmt = $mysqli->prepare($strSql)){
        //     $stmt->bind_param('s', $idusuario);
        //     // si la consulta no contiene ningun error en la sintaxis ejecutamos la consulta
        //     if ($stmt->execute()) {
        //         // obtener los resultados dentro de un arreglo asociado
        //         $result = $stmt->get_result();
        //         $arregloResultados = $result->fetch_all(MYSQLI_ASSOC);
        //         echo $arregloResultados[0]["nombre"];
        //     } else {
        //         $stmt->error;
        //     }

        // } else {

        //     // si la consulta tiene algun error en la sintaxis nos dara este error
        //     echo "Error al preparar la consulta " . $myqsli->error;
        // }
    }

    $mysqli->close();
    
?>

