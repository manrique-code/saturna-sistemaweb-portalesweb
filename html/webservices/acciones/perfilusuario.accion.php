<?php
    if(isset($post_operacion)){
        switch($post_operacion){
            case "editarPerfilUsuario": 
                if(isset($post_idusuario, $post_nombre, $post_email, $post_fechanacimiento, $post_password, $post_celular, $post_image)){
                    if(empty($post_password)) {
                        $post_fechanacimiento = new DateTime($post_fechanacimiento);
                        $post_fechanacimiento = $post_fechanacimiento->format("Y-m-d");

                        if (!empty($post_image)) {
                            $imageName = "/home/administrador/www/html/uploads/imagenes_usuarios/$post_idusuario.png";
                            file_put_contents($imageName, file_get_contents($post_image));
                            $resizableImage = imagecreatefrompng($imageName);
                            imagepng(imagescale($resizableImage, 250, 250), $imageName, 0);
                            if(empty($post_nombre)) {
                                $text = "Usuario actualizado con exito.";
                                $type = "success";
                                $title = "Exito";
                            }
                        }

                        $strsql = "UPDATE usuarios
                            SET nombre = ?,
                                email = ?,
                                fecha_nacimiento = ?,
                                celular = ?
                            WHERE idusuario = ?";

                        $parametros = [
                            $post_nombre,
                            $post_email,
                            $post_fechanacimiento,
                            $post_celular,
                            $post_idusuario
                        ];

                        $queryData = $f->exeQuery($strsql, $parametros);
                        if (!$queryData["error"]) {
                            $text = "Usuario actualizado con exito.";
                            $type = "success";
                            $title = "Exito";
                            unset($parametros[4]);
                            unset($parametros[5]);
                            $parametros[4] = $post_image;
                            $datareturn = $parametros;
                        } else {
                            $text = "Ocurrio un error al crear el usuario: " . $queryData["error"];
                        }
                    } else {
                        $post_fechanacimiento = new DateTime($post_fechanacimiento);
                        $post_fechanacimiento = $post_fechanacimiento->format("Y-m-d");

                        if (!empty($post_image)) {
                            $imageName = "/home/administrador/www/html/uploads/imagenes_usuarios/$post_idusuario.png";
                            file_put_contents($imageName, file_get_contents($post_image));
                            $resizableImage = imagecreatefrompng($imageName);
                            imagepng(imagescale($resizableImage, 250, 250), $imageName, 0);
                            if(empty($post_nombre)) {
                                $text = "Usuario actualizado con exito.";
                                $type = "success";
                                $title = "Exito";
                            }
                        }
                        // el usuario cambia la contraseña
                        $strsql = "UPDATE usuarios
                            SET nombre = ?,
                                email = ?,
                                fecha_nacimiento = ?,
                                celular = ?,
                                password = ?
                            WHERE idusuario = ?;";
                        $llave = hash("sha512", rand());
                        $post_password = hash("sha512", $post_password);     
                        $parametros = [
                            $post_nombre,
                            $post_email,
                            $post_fechanacimiento,
                            $post_celular,
                            $post_password,
                            $post_idusuario
                        ];

                        $queryData = $f->exeQuery($strsql, $parametros);
                        if (!$queryData["error"]) {
                            $text = "Usuario actualizado de manera correcta";
                            $type = "success";
                            $title = "Exito";
                            unset($parametros[4]);
                            unset($parametros[5]);
                            $datareturn = $parametros;
                        } else {
                            $text = "Ocurrio un error al crear el usuario: " . $queryData["error"];
                        }
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

    function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp ); 

        return $output_file; 
    }
?>