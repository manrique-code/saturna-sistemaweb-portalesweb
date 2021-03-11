<?php
    // Web Service Master
    header("content-type:application/json;charset=UTF-8");
    require "../config.php";
    require "../funciones.php";

    $type = "error";
    $text = "Error desconocido";
    $title = "Error!";
    $datareturn = [];
    $dataonly = false;
    $accion = isset($_GET["accion"]) ? $_GET["accion"] : false;
    $variablesPOST = $_POST;

    foreach($variablesPOST as $nombre=>$valor){
        $nombre = "post_$nombre";
        $$nombre = $valor;
    }

    if($accion) {
        if(file_exists("acciones/$accion.accion.php")){
            require "acciones/$accion.accion.php";
        } else {
            $text = "No existe el archivo de la accion solicitada";
        }
    } else {
        $text = "No definión la acción que desea ejecutar";
    }

    $return = [
        "type"=>$type,
        "text"=>$text,
        "title"=>$title,
        "datareturn"=>$datareturn
    ];

    echo json_encode($return);

?>