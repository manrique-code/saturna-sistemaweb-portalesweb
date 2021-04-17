<?php
    if(isset($post_operacion)){
        switch($post_operacion){
            case "crearUsuario":
                /*
                    endPoint para crear usuarios
                    se requiere:
                        idusuario
                        nombre
                        email
                        fechanacimiento
                        password (encriptado en SHA512)
                        celular
                        essuperadmin
                        estado (0: inactivo, otro valor: activo)
                */
                if(isset(
                    $post_idusuario,
                    $post_nombre,
                    $post_email,
                    $post_fechanacimiento,
                    $post_password,
                    $post_celular,
                    $post_essuperadmin,
                    $post_estado
                    )){
                    if (
                        !empty($post_idusuario)
                        && !empty($post_nombre)
                        && filter_var($post_email, FILTER_VALIDATE_EMAIL) 
                        && !empty($post_celular)
                    ) {
                        try {
                            $post_fechanacimiento = new DateTime($post_fechanacimiento);
                            $post_fechanacimiento = $post_fechanacimiento->format("Y-m-d");
                            $llave = hash("sha512",rand());
                            $post_password = hash("sha512",$post_password);
                            $strsql = "
                            INSERT INTO usuarios(
                                idusuario,
                                nombre,
                                email, 
                                fecha_nacimiento, 
                                llave, 
                                password, 
                                celular, 
                                superadministrador, 
                                activo
                            ) VALUES(?,?,?,?,?,?,?,?,?)";                            
                            $parametros = [
                                $post_idusuario, 
                                $post_nombre, 
                                $post_email, 
                                $post_fechanacimiento, 
                                $llave,
                                $post_password, 
                                $post_celular, 
                                $post_essuperadmin ? 1 : 0, 
                                $post_estado ? 1 : 0
                            ];
                            $queryData = $f->exeQuery($strsql, $parametros);
                            if(!$queryData["error"]){
                                $text = "Usuario Creado Exitosamente";
                                $type = "success";
                                $title = "Exito";
                                unset($parametros[4]);
                                unset($parametros[5]);
                                $datareturn = $parametros;
                            }
                            else{
                                $text = "Ocurrio un error al crear el usuario: " . $queryData["error"];
                                $type = "error";
                                $title = "Exito";
                                unset($parametros[4]);
                                unset($parametros[5]);
                                $datareturn = $parametros;
                            }
                        }
                         catch (Exception $e) {
                            $text =  "No envio una fecha de nacimiento valida";
                        }
                    }
                    else{
                        $text = "Los datos enviados no estan en el formato correcto.";
                    }
                }
                else{
                    $text = "No envio todos los datos necesarios para crear el usuario";
                }
            break;
            case "editarUsuario": 
                if (isset(
                        $post_idusuario,
                        $post_nombre,
                        $post_email,
                        $post_fechanacimiento,
                        $post_password,
                        $post_celular
                    )) {
                    $strsql = "";
                    $parametros = [];
                    if (empty($post_password)) {
                        $strsql = "
                            UPDATE usuarios
                            SET nombre = ?,
                                email = ?,
                                fecha_nacimiento = ?,
                                celular = ?
                            WHERE idusuario = ?;
                        ";
                        $parametros = [
                            $post_nombre,
                            $post_email,
                            $post_fechanacimiento,
                            $post_celular,
                            $post_idusuario
                        ];
                    } else {
                        $llave = hash("sha512", rand());
                        $post_password = hash("sha512", $post_password);  
                        $strsql = "
                            UPDATE usuarios
                            SET nombre = ?,
                                email = ?,
                                fecha_nacimiento = ?,
                                celular = ?,
                                llave = ?,
                                password = ?
                            WHERE idusuario = ?;
                        ";
                        $parametros = [
                            $post_nombre,
                            $post_email,
                            $post_fechanacimiento,
                            $post_celular,
                            $llave,
                            $post_password,
                            $post_idusuario
                        ];
                    }
                       $queryData = $f->exeQuery($strsql, $parametros);
                       if (!$queryData["error"]) {
                            $text = "Datos ingresados de manera correcta";
                            $type = "success";
                            $title = "Éxito";
                            $datareturn = $parametros;
                       } else {
                            $text = "Ha ocurrido un error al ingresar el usuario. Por favor intentalo más tarde.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$queryData["error"]];     
                       }
                    
                }
                else{
                    $text = "No envio todos los datos necesarios para crear el usuario";
                }
                break;
            case "desactivarUsuario":
                if (isset(
                        $post_idusuario,
                        $post_estado
                    )) {
                    // revisar si el usuario que se desea eliminar existe
                    $queryEliminarUsuario = "    
                        SELECT ifnull(COUNT(*), 0) as existeUsuario
                        FROM usuarios
                        WHERE (idusuario = ?);
                    ";
                    $existeUsuario = $f->getQueryData($queryEliminarUsuario, [$post_idusuario]);
                    if ($existeUsuario) {
                        $queryDesactivarUsuario = "
                            UPDATE usuarios
                            SET activo = ?
                            WHERE idusuario = ?;
                        ";
                        $parameters = [$post_estado, $post_idusuario];
                        $queryData = $f->exeQuery($queryDesactivarUsuario, $parameters);
                        if (!$queryData["error"]) {
                            $activo = ($post_estado) ? "activado" : "desactivado";
                            $text = "Usuario $activo de manera correcta";
                            $type = "success";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        } else {
                            $text = "Al parecer el usuario que deseas desactivar no existe. Por favor revisa si los datos brindados son correctos.";
                            $type = "error";
                            $title = "Error"; 
                            $datareturn = $queryData["error"];
                        }
                    } else {
                        $text = "Al parecer el usuario que deseas eliminar no existe. Por favor revisa si los datos brindados son correctos.";
                        $type = "error";
                        $title = "Error";    
                    }
                } else {
                    $text = "No se enviarón todos los parámetros necesarios para eliminar el usuario.";
                    $type = "error";
                    $title = "Error";
                }
                break;
            case "eliminarUsuario":
                if (isset(
                        $post_idusuario
                    )) {
                    // revisar si el usuario que se desea eliminar existe
                    $queryEliminarUsuario = "    
                        SELECT ifnull(COUNT(*), 0) as existeUsuario
                        FROM usuarios
                        WHERE (idusuario = ?);
                    ";
                    $existeUsuario = $f->getQueryData($queryEliminarUsuario, [$post_idusuario]);
                    if ($existeUsuario["data"][0]["existeUsuario"]) {
                        $querySql = "
                            DELETE FROM usuarios
                            WHERE idusuario = ?
                        ";
                        $queryData = $f->exeQuery($querySql, [$post_idusuario]);
                        if (!$queryData["error"]) {
                            $text = "Usuario eliminado de manera correcta.";
                            $type = "success";
                            $title = "Éxito";  
                        } else {
                            $text = "Al parecer el usuario que deseas eliminar no existe. Por favor revisa si los datos brindados son correctos.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$queryData["error"]];  
                        }
                    } else {
                        $text = "Al parecer el usuario que deseas eliminar no existe. Por favor revisa si los datos brindados son correctos.";
                        $type = "error";
                        $title = "Error";    
                    }
                } else {
                    $text = "No se enviarón todos los parámetros necesarios para eliminar el usuario.";
                    $type = "error";
                    $title = "Error";
                }
                break;
            case "verificarUsuario": 
                if (isset($post_idusuario)) {
                    $queryUsuarioExiste = "
                        SELECT ifnull(COUNT(*), 0) as existeUsuario
                        FROM usuarios
                        WHERE idusuario = ?;
                    ";
                    $existeUsuario = $f->getQueryData($queryUsuarioExiste, [$post_idusuario]);
                    if ($existeUsuario["data"][0]["existeUsuario"]) {
                        $text = "Este código de usuario ya existe.";
                        $type = "error";
                        $title = "Error";  
                    } else {
                        $text = "Código de usuario válido.";
                        $type = "success";
                        $title = "Éxito";
                        $datareturn = [$existeUsuario["data"][0]["existeUsuario"]];
                    }
                } else {
                    $text = "No se enviarón todos los parámetros necesarios para verificar el usuario.";
                    $type = "error";
                    $title = "Error";
                }
                break;
            default:
                $text = "no envio una operación valida";
                break;
        }
    }
    else{
        $text = "No envio la operación que desea ejecutar";
    }
?>