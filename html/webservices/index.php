<?php
    //Web Service Master
    header("content-type: application/json;charset=UTF-8");
    require_once "../config.php";
    require_once "../funciones.php";
    $protocolo = "http://"; //Pendiente de verificar si es HTTPS
    $urlSite = $protocolo . $_SERVER['SERVER_NAME'];

    $type = "error"; //warning, success
    $text = "Error Desconocido";
    $title = "Error!";
    $datareturn = [];
    $dataonly = false;
    $accion = isset($_GET["mod"]) ? $_GET["mod"] : false;
    $variablesPOST = $_POST;
    $mysqli = new mysqli($mysql_svr, $mysql_usr, $mysql_psw, $mysql_db);
    if ($mysqli->connect_errno) {
        $text = "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    else{
        $f = new funciones($mysqli, $urlSite, $domain = $_SERVER['SERVER_NAME']);
        $f->inicio_sesion();  
        foreach($variablesPOST as $nombre=>$valor){
            $nombre = "post_$nombre";
            $$nombre=$valor;
        }
   
        if($accion){
            if(file_exists("acciones/$accion.accion.php")){
                require "acciones/$accion.accion.php";
            }
            else{
                $text = "No existe el archivo de la accion solicitada";
            }
        }
        else{
            $text = "No definio la accion que desea ejecutar";
        }
        $mysqli->close();
    }
    
    $retorno = [
        "type"=>$type,
        "icon"=>$type,
        "text"=>$text,
        "title"=>$title,
        "datareturn"=>$datareturn
    ];


    echo json_encode($retorno);
?>