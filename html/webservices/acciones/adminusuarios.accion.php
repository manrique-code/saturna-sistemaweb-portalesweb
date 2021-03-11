<?php
    if (isset($post_operacion)){
        switch($post_operacion){
            case "crearUsuario":
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
                    if(
                        !empty($post_idusuario) &&
                        !empty($post_nombre) &&
                        filter_var($post_email, FILTER_VALIDATE_EMAIL) &&
                        strlen($post_password) == 128 &&
                        !empty($post_celular)
                    ) {
                        $post_fechanacimiento = strtotime($post_fechanacimiento)
                        if($post_fechanacimiento !== false){

                        } else {
                            $text = "No se pudo validar la fecha de nacimiento";
                        }
                    } else {
                        $text = "Los datos enviados no están en el formato correcto";
                    }
                } else {
                    $text="No envió todos los datos necesarios para crear el usuario";
                }
                break;
            default:
                $text = "No envió una operación válida";
                break;
        }
    } else {
        $text = "No envión la operación que desea ejecutar";
    }
?>