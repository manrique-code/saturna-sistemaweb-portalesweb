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
                if(isset($post_idusuario, $post_nombre, $post_email, $post_fechanacimiento, $post_password, $post_celular, $post_essuperadmin, $post_estado)){
                    if(!empty($post_idusuario) && !empty($post_nombre) && filter_var($post_email, FILTER_VALIDATE_EMAIL) && strlen($post_password)==128 && !empty($post_celular)){
                        try {
                            $post_fechanacimiento = new DateTime($post_fechanacimiento);
                            $post_fechanacimiento = $post_fechanacimiento->format("Y-m-d");

                            $llave = hash("sha512",rand());
                            $post_password = hash("sha512",$post_password . $llave);

                            $strsql = "INSERT INTO usuarios(idusuario, nombre, email, fecha_nacimiento
                                                            , llave, password, celular
                                                            , superadministrador, activo)
                                        VALUES(?,?,?,?,?,?,?,?,?)";
                            
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
            case "editarPerfilUsuario": 
                if(isset($post_idusuario, $post_nombre, $post_email, $post_fechanacimiento, $post_password, $post_celular)){
                    if(empty($post_password)) {
                        $strsql = "
                            UPDATE usuarios
                            SET nombre = ?,
                                email = ?,
                                fecha_nacimiento = ?,
                                celular = ?,
                            WHERE idusuario = ?

                        ";

                        $parametros = [
                            $post_nombre,
                            $post_email,
                            $post_fechanacimiento,
                            $post_celular,
                            $post_idusuario
                        ];

                        $text = "Datos ingresados de manera correcta";
                        $type = "success";
                        $title = "Exito";
                        unset($parametros[4]);
                        unset($parametros[5]);
                        $datareturn = $parametros;
                    } else {
                        
                    }
                }
                else{
                    $text = "No envio todos los datos necesarios para crear el usuario";
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