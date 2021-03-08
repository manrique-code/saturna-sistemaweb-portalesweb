<?php
    // vamos a tener todas las funciones
    // vamos a crear un objeto para que mantenga todas las funciones
    class funciones {
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
                foreach ($parametros as $parametro) {
                    if (gettype($parametro) == "string" || gettype($parametro) == "NULL"){
                        $parametrosTipos .= "s";
                    } elseif (gettype($parametro) == "integer"){
                        $parametrosTipos .= "i";
                    } elseif (gettype($parametro) == "double"){
                        $parametrosTipos .= "d";
                    } else {
                        $error = "Tipo de dato de parametro no reconocido";
                    }
                }

                if (!$error){
                    // los tres puntos es funcionas como el spread operator de javascript
                    if(!empty($parametros)) $stmt->bind_param($parametrosTipos,...$parametros);
                    if ($stmt->execute()){
                        $result = $stmt->get_result();
                        $data = $result->fetch_all(MYSQLI_ASSOC);
                    } else {
                        $error = $stmt->error;
                    }
                }

                $stmt->close();

            } else {
                $error = $this->mysqli->error;
            }

            return [
                "error"=>$error,
                "data"=>$data
            ];
        }

        function exeQuery($strsql, $parametros=[]){
            $error = false;
            $affected = null;
            $lastId = null;
            $parametrosTipos = "";

            if($stmt = $this->mysqli->prepare($strsql)){
                foreach ($parametros as $parametro) {
                    if (gettype($parametro) == "string" || gettype($parametro) == "NULL"){
                        $parametrosTipos .= "s";
                    } elseif (gettype($parametro) == "integer"){
                        $parametrosTipos .= "i";
                    } elseif (gettype($parametro) == "double"){
                        $parametrosTipos .= "d";
                    } else {
                        $error = "Tipo de dato de parametro no reconocido";
                    }
                }

                if (!$error){
                    // los tres puntos es funcionas como el spread operator de javascript
                    if(!empty($parametros)) $stmt->bind_param($parametrosTipos,...$parametros);
                    if ($stmt->execute()){
                        $affected = $stmt->affected_rows;
                        $lastId = $stmt->insert_id;                      
                    } else {
                        $error = $stmt->error;
                    }
                }

            } else {
                $error = $this->mysqli->error;
            }

            return [
                "error"=>$error,
                "affected"=>$affected,
                "lastId"=>$lastId
            ];
        }

        function modulo($idmodulo){
            // como nosotros vamos a llamar un modulo
            // primero verificamos que ese modulo exista en la base de datos
            $strsql = "SELECT modulo, tipo, mostrartitulo, contenido FROM modulos WHERE idmodulo = ?";
            $queryData = $this->getQueryData($strsql, [$idmodulo]);
            $error = false;
            if(!$queryData["error"]){
                if(count($queryData["data"])){ 
                    // tomamos el indice cero porque basicamente es el unico resultado que vamos a tener.
                    $moduloData = $queryData["data"][0];
                    $tipo = $moduloData["tipo"];
                    $modulo = $moduloData["modulo"];

                    if($moduloData["mostrartitulo"]) echo "<h2>$modulo</h2>";

                    if($tipo){
                        // es un modulo de PHP
                        if(file_exists("modulos/$idmodulo.modulo.php")){
                            require("modulos/$idmodulo.modulo.php");
                            if(file_exists("modulos/js/$idmodulo.script.js")){
                                echo "<script src='$this->urlSite/modulos/js/$idmodulo.script.js'></script>";
                            }
                        } else {
                            $error = "Archivo del modulo no existe";
                        }
                    } else {
                        // es un modulo de contenido
                        echo $moduloData["contenido"];
                    }
                } else {
                    // el modulo que pusimos dentro de la consulta no existe;
                    $error = "El modulo solicitado no existe";
                }
            } else {
                // la consulta tiene algun error de sintaxis.
                $error = "No se pudo ejecutar la consulta del modulo: ".$queryData["error"];
            }

            if($error){
                echo "<h1>Error al buscar el modulo</h1>";
                echo "<p>$error</p>";
            }
        }
    }
?>