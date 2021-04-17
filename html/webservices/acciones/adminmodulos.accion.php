<?php 

global $f;

if (isset($post_operacion)) {
    switch($post_operacion){
        /*
        * Campos del base de datos.
        * idmodulo: varchar(50) PK
        * modulo: varchar(255)
        * tipo: int(11)
        * mostrararticulo: int(11)
        * contenido: text
        */
        case "verificar":
            if (isset($post_idmodulo)) {
                try {
                    $queryVerifyModulo = "
                        select IFNULL(COUNT(*), 0) as existeModulo
                        from modulos
                        where (idmodulo = ?);
                    ";
                    $existeModulo = $f->getQueryData($queryVerifyModulo, [$post_idmodulo]);
                    if (!$existeModulo["error"]) {
                        if ($existeModulo["data"][0]["existeModulo"]) {
                            $text = "Este id de módulo ya existe.";
                            $type = "error";
                            $title = "Error";
                        } else {
                            $text = "El id de este módulo es válido.";
                            $type = "success";
                            $title = "Éxito";
                        }
                    } else {
                        $text = "Ha ocurrido un error al consultar si existe este modulo. Por favor intentalo más tarde.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$existeModulo["error"]];
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al intentar realizar la accion de verificar módulo. Para más información contacte con el administrador del blog.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$e];
                }
            } else {
                $text = "Ups! Que no se te olvide ingresar los datos del módulo.";
                $type = "error";
                $title = "Error";
            }
            break;

        case "crear":
            if (isset(
                $post_idmodulo,
                $post_modulo,
                $post_tipo,
                $post_mostrartitulo
            )) {
                try {
                    $queryCrearModulo = "
                        INSERT INTO modulos(
                            idmodulo,
                            modulo,
                            tipo,
                            mostrartitulo
                        ) VALUES (?, ?, ?, ?);
                    ";
                    $parametros = [
                        $post_idmodulo,
                        $post_modulo,
                        $post_tipo,
                        $post_mostrartitulo
                    ];
                    $queryData = $f->exeQuery($queryCrearModulo, $parametros);
                    if (!$queryData["error"]) {
                        $text = "El módulo ha sido creado correctamente.";
                        $type = "success";
                        $title = "Ok";
                        // ya que el modulo se creó en la base de datos procedemos a crear los archivos correspondientes de estos módulos
                        // ingeniero si lee esta línea de código, yo tomé en consideración que los módulos 1 son PHP y que los módulos de tipo 0 son contenido estático HTML
                        switch ($post_tipo) {
                            case 0:
                                // si es contenido estático
                                $modulo = "/home/administrador/www/html/modulos/$post_idmodulo.modulo.html";
                                file_put_contents($modulo, "");
                                break;
                            case 1:
                                // si es php
                                $modulo = "/home/administrador/www/html/modulos/$post_idmodulo.modulo.php";
                                $accion = "/home/administrador/www/html/webservices/acciones/$post_idmodulo.accion.php";
                                file_put_contents($modulo, "");
                                file_put_contents($accion, "");
                                break;
                            default:
                                $text = "Tipo de módulo incorrecto, este debe ser tipo 1 o 0";
                                break;
                        }
                    } else {
                        $text = "Ha ocurrido un error al intentar crear el módulo $post_modulo. Por favor intenta de nuevo más tarde";
                        $type = "error";
                        $title = "Error";    
                        $datareturn = [$queryData["error"]];
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al intentar la operación de crear módulos. Por favor contacte con el administrador del blog para más información.";
                    $type = "error";
                    $title = "Error";    
                    $datareturn = [$e];
                }
            } else {
                $text = "Ups! Que no se te olvide ingresar los datos del módulo.";
                $type = "error";
                $title = "Error";
                $datareturn = [
                    $post_idmodulo,
                    $post_modulo,
                    $post_tipo,
                    $post_mostrartitulo
                ];
            }
            break;

        case "editar":
            if (isset(
                $post_modulo,
                $post_mostrartitulo,
                $post_contenidomodulo,
                $post_contenidoaccion,
                $post_contenidojavascript,
                $post_tipo,
                $post_idmodulo
            )) {
                try {
                    // verificar que el id existe antes de ingresarlo
                    $queryExisteModulo = "
                        select IFNULL(COUNT(*), 0) as existeModulo
                        from modulos
                        where (idmodulo = ?);
                    ";
                    $existeModulo = $f->getQueryData($queryExisteModulo, [$post_idmodulo]);
                    $queryEditarModulo = "";
                    $parametros = [];
                    $cambiarContenidoModulo = false;
                    if (!$existeModulo["error"]) {
                        if ($existeModulo["data"][0]["existeModulo"]) {
                            $rootPathServer = "/home/administrador/www/html";
                            if (trim($post_contenidomodulo)) {
                                $queryEditarModulo = "
                                    UPDATE modulos
                                    SET modulo = ?,
                                        mostrartitulo = ?,
                                        contenido = ?
                                    WHERE idmodulo = ?;
                                ";
                                $parametros = [
                                    $post_modulo,
                                    $post_mostrartitulo,
                                    $post_contenidomodulo,
                                    $post_idmodulo
                                ];
                            } else {
                                $queryEditarModulo = "
                                    UPDATE modulos
                                    SET modulo = ?,
                                        mostrartitulo = ?
                                    WHERE idmodulo = ?;
                                ";
                                $parametros = [
                                    $post_modulo,
                                    $post_mostrartitulo,
                                    $post_idmodulo
                                ];
                            }
                            $queryData = $f->exeQuery($queryEditarModulo, $parametros);
                            if (!$queryData["error"]) {
                                if (trim($post_contenidomodulo)) {
                                    $urlArchivoModulo = (intval($post_tipo)) ? "$rootPathServer/modulos/$post_idmodulo.modulo.php" : "$rootPathServer/modulos/$post_idmodulo.modulo.html";
                                    file_put_contents($urlArchivoModulo, $post_contenidomodulo);
                                } 
                                if (trim($post_contenidoaccion)) {
                                    $urlArchivoAccion = "$rootPathServer/webservices/acciones/$post_idmodulo.accion.php";
                                    file_put_contents($urlArchivoAccion, $post_contenidoaccion);
                                }
                                if (trim($post_contenidojavascript)) {
                                    $urlArchivoScript = "$rootPathServer/modulos/js/$post_idmodulo.script.js";
                                    file_put_contents($urlArchivoScript, $post_contenidojavascript);
                                }
                                $text = "Modulo editado correctamente.";
                                $type = "success";
                                $title = "Éxito";    
                                $datareturn = [$queryData["error"]];
                            } else {
                                $text = "Error al intentar editar el módulo. Intentalo de nuevo más tarde.";
                                $type = "error";
                                $title = "Error";    
                                $datareturn = [$queryData["error"]];
                            }
                        } else {
                            $text = "El módulo que deseas editar no existe. Por favor intenta con otro módulo.";
                            $type = "error";
                            $title = "Error";    
                            $datareturn = [$existeModulo["error"]];    
                        }
                    } else {
                        $text = "Ha ocurrido un error intentando verificar la autenticidad de este id.";
                        $type = "error";
                        $title = "Error";    
                        $datareturn = [$existeModulo["error"]];
                    }
                } catch (Exception $e){
                    $text = "Ha ocurrido un error al intentar la operación de editar módulo. Para más información, por favor contacte con el administrador del blog.";
                    $type = "error";
                    $title = "Error";    
                    $datareturn = [$e];
                }
            } else {
                    $text = "No pasaste todos los parametros necesarios para editar este módulo.";
                    $type = "error";
                    $title = "Error";  
            }
            break;
        case "eliminar":
            if (isset(
                    $post_idmodulo,
                    $post_tipo
                )) {
                try {
                    if ($post_idmodulo !== "adminmodulos") {
                        // verificar que el id del modulo existe
                        $queryExisteModulo = "
                            select IFNULL(COUNT(*), 0) as existeModulo
                            from modulos
                            where (idmodulo = ?);
                        ";
                        $existeModulo = $f->getQueryData($queryExisteModulo, [$post_idmodulo]);
                        if (!$existeModulo["error"]) {
                            if ($existeModulo["data"][0]["existeModulo"]) {
                                $rootPathServer = "/home/administrador/www/html";
                                $queryEliminarModulo = "
                                    DELETE FROM modulos
                                    WHERE idmodulo = ?
                                ";
                                $queryData = $f->exeQuery($queryEliminarModulo, [$post_idmodulo]);
                                if (!$queryData["error"]) {
                                    $urlArchivoModulo = (intval($post_tipo)) ? "$rootPathServer/modulos/$post_idmodulo.modulo.php" : "$rootPathServer/modulos/$post_idmodulo.modulo.html";
                                    $urlArchivoAccion = "$rootPathServer/webservices/acciones/$post_idmodulo.accion.php";
                                    $urlArchivoScript = "$rootPathServer/modulos/js/$post_idmodulo.script.js";
                                    if (file_exists($urlArchivoAccion)) unlink($urlArchivoAccion);
                                    if (file_exists($urlArchivoScript)) unlink($urlArchivoScript);
                                    if (file_exists($urlArchivoModulo)) unlink($urlArchivoModulo);
                                    $text = "¡Módulo eliminado de la manera correcta!.";
                                    $type = "success";
                                    $title = "Éxito";
                                    $datareturn = [$post_idmodulo, $post_tipo];
                                } else {
                                    $text = "Ha ocurrido un error intentando eliminar este modulo.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El módulo que desea eliminar no existe. Intenta más tarde con otro módulo.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error intentando verificar la autenticidad de este id.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeModulo["error"]];        
                        }
                    } else {
                        $text = "Acción no válida. Usted no puede eliminar este módulo.";
                        $type = "error";
                        $title = "Error";    
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al intentar la operación de eliminar este módulo. Para más información, por favor contacte con el administrador del blog.";
                    $type = "error";
                    $title = "Error";    
                    $datareturn = [$e];
                }
            } else {
                $text = "No pasaste todos los argumentos necesarios para eliminar este módulo.";
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