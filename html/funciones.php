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
    }
?>