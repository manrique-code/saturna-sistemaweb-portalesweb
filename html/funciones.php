<?php
    // vamos a tener todas las funciones
    // vamos a crear un objeto para que mantenga todas las funciones
    class funciones {
        private $mysqli;

        function __construct($mysqli){
            $this->mysqli = $mysqli;
        }

        function getQueryData($strsql, $parametros=[]){
            $error = false;
            $data = [];
            $parametrosTipos = "";

            if($stmt = $this->mysqli->prepare($strsql)){
                foreach $parametros as $parametro {
                    if (gettype($parametro) == "string"){
                        $params .= "s";
                    } elseif (gettype($parametro) == "integer"){
                        $params .= "i";
                    } elseif (gettype($parametro) == "double"){
                        $params .= "d";
                    } else {
                        $error = "Tipo de dato de parametro no reconocido";
                    }
                }

                if (!error){
                    if(!empty($parametrosTipos)) $stmt->bind_param($parametrosTipos, $parametros);
                }

            } else {
                $error = $this->mysqli->error;
            }

            return [
                "error"=>$error,
                "data"=>$data
            ];
        }
    }
?>