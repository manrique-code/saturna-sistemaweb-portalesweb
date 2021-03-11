<?php
class funciones{
    private $mysqli;
    private $urlSite;

    function __construct($mysqli, $urlSite){
        $this->mysqli = $mysqli;
        $this->urlSite = $urlSite;
    }

    function getQueryData($strsql, $parametros=[]){
        $error = false;
        $data = [];
        $parametrosTipos = "";
        if($stmt = $this->mysqli->prepare($strsql)){
            foreach($parametros as $parametro){
                if(gettype($parametro) == "string" || gettype($parametro) == "NULL"){
                    $parametrosTipos .= "s";
                }
                elseif(gettype($parametro) == "integer"){
                    $parametrosTipos .= 'i';
                }
                elseif(gettype($parametro) == "double"){
                    $parametrosTipos .= 'd';
                }
                else{
                    $error = "Tipo de Dato de paramentro no reconocido";
                }
            }
            if(!$error){
                if(!empty($parametros)) $stmt->bind_param($parametrosTipos,...$parametros);
                if($stmt->execute()){
                    $result = $stmt->get_result(); //Obtenemos los resultados
                    $data = $result->fetch_all(MYSQLI_ASSOC);
                }
                else{
                    $error = $stmt->error;
                }
            }
            $stmt->close(); 
        }
        else{
            $error = $this->mysqli->error;
        }
        return [
            "error"=>$error,
            "data"=>$data
        ];
    }

    function exeQuery($strsql, $parametros=[]){
        $error = false;
        $afected = null;
        $lastId = null;

        $parametrosTipos = "";
        if($stmt = $this->mysqli->prepare($strsql)){
            foreach($parametros as $parametro){
                if(gettype($parametro) == "string" || gettype($parametro) == "NULL"){
                    $parametrosTipos .= "s";
                }
                elseif(gettype($parametro) == "integer"){
                    $parametrosTipos .= 'i';
                }
                elseif(gettype($parametro) == "double"){
                    $parametrosTipos .= 'd';
                }
                else{
                    $error = "Tipo de Dato de paramentro no reconocido";
                }
            }
            if(!$error){
                if(!empty($parametros)) $stmt->bind_param($parametrosTipos,...$parametros);
                if($stmt->execute()){
                    $afected = $stmt->affected_rows;
                    $lastId = $stmt->insert_id;
                }
                else{
                    $error = $stmt->error;
                }
            }
        }
        else{
            $error = $this->mysqli->error;
        }
        return [
            "error"=>$error,
            "afected"=>$afected,
            "lastid"=>$lastId
        ];
    }

    function modulo($idmodulo){
        $strsql = "SELECT modulo, tipo, mostrartitulo, contenido FROM modulos WHERE idmodulo = ?";
        $queryData = $this->getQueryData($strsql,[$idmodulo]);
        $error = false;
        if(!$queryData["error"]){
            if(count($queryData["data"])){
                $moduloData = $queryData["data"][0];
                $tipo = $moduloData["tipo"];
                $modulo = $moduloData["modulo"];
                if($moduloData["mostrartitulo"]) echo "<h2>$modulo</h2>";

                if($tipo){
                    //Es un modulo PHP
                    if(file_exists("modulos/$idmodulo.modulo.php")){
                        require "modulos/$idmodulo.modulo.php";
                        if(file_exists("modulos/js/$idmodulo.script.js")){
                            echo "<script>const idmodulo = '$idmodulo';</script>";
                            echo "<script src='$this->urlSite/modulos/js/$idmodulo.script.js'></script>";
                        }
                    }
                    else{
                        $error = "Archivo del modulo no existe";
                    }
                }
                else{
                    //Es un Modulo Contenido
                    echo $moduloData["contenido"];
                }
            }
            else{
                $error = "El modulo solicitado no existe";
            }
        }
        else{
            $error = "No se pudo ejecutar la consulta del modulo: ".$queryData["error"];
            
        }

        if($error){
            echo "<h1>Error al Buscar el modulo</h1>";
            echo "<p>$error</p>";
        }
    }

}