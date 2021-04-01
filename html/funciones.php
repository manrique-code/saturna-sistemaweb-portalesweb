<?php
class funciones{
    private $mysqli;
    private $urlSite;
    private $cookieDomain;

    function __construct($mysqli, $urlSite, $cookieDomain){
        $this->mysqli = $mysqli;
        $this->urlSite = $urlSite;
        $this->cookieDomain = $cookieDomain;
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
            echo "<h2>Error al Buscar el modulo</h2>";
            echo "<p>$error</p>";
        }
    }

    function bloque($idbloque){
        $strsql = "SELECT bloque, tipo, mostrartitulo, contenido FROM bloques WHERE idbloque = ?";
        $queryData = $this->getQueryData($strsql,[$idbloque]);
        $error = false;
        if(!$queryData["error"]){
            if(count($queryData["data"])){
                $bloqueData = $queryData["data"][0];
                $tipo = $bloqueData["tipo"];
                $bloque = $bloqueData["bloque"];
                if($bloqueData["mostrartitulo"]) echo "<h2>$bloque</h2>";

                if($tipo){
                    //Es un bloque PHP
                    if(file_exists("bloques/$idbloque.bloque.php")){
                        require "bloques/$idbloque.bloque.php";
                        if(file_exists("bloques/js/$idbloque.script.js")){
                            echo "<script src='$this->urlSite/bloques/js/$idbloque.script.js'></script>";
                        }
                    }
                    else{
                        $error = "Archivo del bloque no existe";
                    }
                }
                else{
                    //Es un bloque Contenido
                    echo $bloqueData["contenido"];
                }
            }
            else{
                $error = "El bloque solicitado no existe";
            }
        }
        else{
            $error = "No se pudo ejecutar la consulta del bloque: ".$queryData["error"];
            
        }

        if($error){
            echo "<h1>Error al Buscar el bloque</h1>";
            echo "<p>$error</p>";
        }
    }
    // debemos asegurarnos que sea lo primero que llamemos cuando inciamos sesion
    function inicio_sesion() {
        $sessionName = "pw_sistemaModular";
        $secure = false;
        $httponly = true;
        // calculamos los segundos que dura cinco dia
        $expire_cookie = (24*60*60) * 5;

        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            echo "No se pudo iniciar una sesión segura (ini_set)";
            exit();
        }

        $cookieParam = session_get_cookie_params();

        session_set_cookie_params(
            $expire_cookie,
            $cookieParam["path"],
            $this->cookieDomain,
            $secure,
            $httponly
        );

        session_name($sessionName);
        session_start();
    }

    // funcion para saber si un usuario inicio sesion
    function login($idusuario, $sha512password) {
        $error = false;
        // obteniendo la llave y la contra del usuario
        $strsql = "SELECT llave, password, nombre, email, activo, idusuario
                    FROM usuarios 
                    WHERE idusuario = ? or email = ?";
        $queryData = $this->getQueryData($strsql, [$idusuario, $idusuario]);
        if (!$queryData["error"]) {
            if (count($queryData["data"]) === 1) {
                $userData = $queryData["data"][0];
                
                if ($userData["activo"]) {
                    $passwordEnviado = $sha512password;
                    if ($passwordEnviado == $userData["password"]) {
                        $_SESSION["idusuario"] = $userData["idusuario"];
                        $_SESSION["email"] = $userData["email"];
                        $_SESSION["nombre"] = $userData["nombre"];
                    } else {
                        $error = "Contraseña incorrecta";
                    }
                } else {
                    $error = "Usuario suspendido";
                }

            } else {
                $error = "El usuario solicitado no existe";
            }
        } else {
            $error = "Ocurrió un error al consultar el usuario" . $queryData["error"];
        }
        return ["error"=>$error];
    }

    function usuarioConectado() {
        $retorno = false;
        if (isset(
            $_SESSION["idusuario"],
            $_SESSION["email"],
            $_SESSION["nombre"]
        )) {
            $retorno = [
                "idusuario"=>$_SESSION["idusuario"],
                "nombre"=>$_SESSION["nombre"],
                "email"=>$_SESSION["email"]
            ];
        }

        return $retorno;
    }

    function esAdmin() {
        $esadmin = false;
        $userData = $this->usuarioConectado();
        if ($userData) {
            $strsql = "SELECT IFNULL(SUM(superadministrador), 0) as esadmin
                        FROM usuarios
                        WHERE idusuario = ? and activo = 1";
            $queryData = $this->getQueryData($strsql, [$userData["idusuario"]]);
            if (!$queryData["error"]) {
                $esadmin = $queryData["data"][0]["esadmin"];
            }
        }
        return $esadmin;
    }

    function existeEmail($email) {
        $existeEmail = "";
        $strsql = "SELECT IFNULL(COUNT(*), 0) as email
                    FROM usuarios
                    WHERE email = ?";

        $queryData = $this->getQueryData($strsql, [$email]);

        if (!$queryData["error"]) {
            $existeEmail = $queryData["data"][0]["email"];
        }
        return $existeEmail;
    }

}