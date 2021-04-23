<?php 

global $f;

if (isset($post_operacion)) {
    switch($post_operacion){
        /*
        * Campos del base de datos.
        * idbloque: varchar(50) PK
        * modulo: varchar(255)
        * tipo: int(11)
        * mostrartitulo: int(11)
        * contenido: text
        */
        case "verificar":
            if (isset(
                $post_idbloque
            )) {
                try {
                    $queryVerifyBloque = "SELECT IFNULL(COUNT(*), 0) AS existeBloque FROM bloques WHERE idbloque = ?;";
                    $existeBloque = $f->getQueryData($queryVerifyBloque, [$post_idbloque]);
                    if (!$existeBloque["error"]) {
                        if (!$existeBloque["data"][0]["existeBloque"]) {
                            $text = "El código del bloque es válido";
                            $type = "success";
                            $title = "ok";
                        } else {
                            $text = "Este código de bloque ya existe.";
                            $type = "error";
                            $title = "Error";
                        }
                    } else {
                        $text = "Ha ocurrido un error tratando de verificar la autenticidad del bloque.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$existeBloque["error"]];
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al realizar la operación de verificación. Para más información consulte con el administrador del blog";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$e];
                }
            } else {
                $text = "No se brindarón los argumentos necesarios para verificar el bloque.";
                $type = "error";
                $title = "Error";
            }
            break;
        
        case "crear":
                if (isset(
                    $post_idbloque,
                    $post_bloque,
                    $post_tipo,
                    $post_mostrartitulo,
                    $post_javascript
                )) {
                    try {
                        // verificar que el bloque no existe antes de crearse
                        $queryVerifyBloque = "SELECT IFNULL(COUNT(*), 0) AS existeBloque FROM bloques WHERE idbloque = ?;";
                        $existeBloque = $f->getQueryData($queryVerifyBloque, [$post_idbloque]);
                        if (!$existeBloque["error"]) {
                            if (!$existeBloque["data"][0]["existeBloque"]) {
                                $queryCreateBloque = "INSERT INTO bloques(idbloque, bloque, tipo, mostrartitulo) VALUES (?, ?, ?, ?);";
                                $parametros = [
                                    $post_idbloque,
                                    $post_bloque,
                                    $post_tipo,
                                    $post_mostrartitulo
                                ];
                                $queryData = $f->exeQuery($queryCreateBloque, $parametros);
                                if (!$queryData["error"]) {
                                    $rootPathServer = "/home/administrador/www/html";
                                    $bloqueArchive = ($post_tipo) ? "$rootPathServer/bloques/$post_idbloque.bloque.php" : "$rootPathServer/bloques/$post_idbloque.bloque.html";
                                    $jsArchive = "$rootPathServer/bloques/js/$post_idbloque.script.js";
                                    $content = ($post_tipo) 
                                    ? "<?php ?>"  
:'<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    
</body>
</html>';

                                    if (file_put_contents($bloqueArchive, $content)) {
                                        if ($post_javascript) {
                                            if (file_put_contents($jsArchive, "")) {
                                                $text = "Ha ocurrido un error tratando de crear el archivo de script del bloque.";
                                                $type = "error";
                                                $title = "Error";
                                            } else {
                                                $text = "Se creó el bloque de manera correcta.";
                                                $type = "success";
                                                $title = "success";
                                                $datareturn = ["linea 102"];
                                            }
                                        } else {
                                            $text = "Se creó el bloque de manera correcta.";
                                            $type = "success";
                                            $title = "success";
                                            $datareturn = ["linea 107"];
                                        }
                                    } else {
                                        $text = "Ha ocurrido un error tratando de crear el archivo del bloque.";
                                        $type = "error";
                                        $title = "Error";
                                    }
                                } else {
                                    $text = "Ha ocurrido un error tratando de crear el bloque.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "No se puede crear el bloque con el código $post_idbloque, porque este ya existe. Por favor, intenta con otro nombre.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del bloque.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeBloque["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al intentar crear el bloque. Para más información contacta con el adminstrador del blog.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No se brindaron los argumentos necesarios para crear el bloque";
                    $type = "error";
                    $title = "Error";
                }
            break;

        case "editar":
                if (isset(
                    $post_idbloque,
                    $post_bloque,
                    $post_tipo,
                    $post_mostrartitulo,
                    $post_contenidoBloque,
                    $post_contenidoScript
                )) {
                    try {
                        $queryVerifyBloque = "SELECT IFNULL(COUNT(*), 0) AS existeBloque FROM bloques WHERE idbloque = ?;";
                        $existeBloque = $f->getQueryData($queryVerifyBloque, [$post_idbloque]);
                        if (!$existeBloque["error"]) {
                            if ($existeBloque["data"][0]["existeBloque"]) {
                                $queryEditarBloque = "UPDATE bloques SET bloque = ?, mostrartitulo = ? WHERE idbloque = ?";
                                $parametros = [
                                    $post_bloque,
                                    $post_mostrartitulo,
                                    $post_idbloque
                                ];
                                $queryData = $f->exeQuery($queryEditarBloque, $parametros);
                                if (!$queryData["error"]) {
                                    $rootPathServer = "/home/administrador/www/html";
                                    $bloqueArchive = ($post_tipo) ? "$rootPathServer/bloques/$post_idbloque.bloque.php" : "$rootPathServer/bloques/$post_idbloque.bloque.html";
                                    $jsArchive = "$rootPathServer/bloques/js/$post_idbloque.script.js";
                                    if (trim($post_contenidoBloque)) {
                                        if (file_exists($bloqueArchive)) {
                                            if (file_put_contents($bloqueArchive, $post_contenidoBloque)) {
                                                if (trim($post_contenidoScript)) {
                                                    if (file_exists($jsArchive)) {
                                                        if ( file_put_contents($jsArchive, $post_contenidoScript) ) {
                                                            $text = "Se creó el bloque de manera correcta.";
                                                            $type = "success";
                                                            $title = "success";
                                                        }
                                                    }
                                                    else {
                                                        $text = "El archivo de javascript que usted desea editar no existe. Es muy posible que haya sido eliminado del servidor.";
                                                        $type = "error";
                                                        $title = "Error"; 
                                                    }
                                                } else {
                                                    $text = "Se creó el bloque de manera correcta.";
                                                    $type = "success";
                                                    $title = "success";
                                                }
                                            } else {
                                                $text = "Se editó el bloque de manera correcta.";
                                                $type = "success";
                                                $title = "success";
                                            }
                                        } else {
                                            $text = "El archivo que usted desea editar no existe. Es muy posible que haya sido eliminado del servidor.";
                                            $type = "error";
                                            $title = "Error"; 
                                        }
                                    } else {
                                        $text = "No se puede editar el archivo con texto vacío.";
                                        $type = "error";
                                        $title = "Error";
                                    }
                                    
                                } else {
                                    $text = "Ha ocurrido un error tratando de editar el bloque.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El bloque que usted desea editar no existe.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del bloque.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeBloque["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al intentar editar el bloque. Para más información contacta con el adminstrador del blog.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No se brindaron los argumentos necesarios para editar el bloque";
                    $type = "error";
                    $title = "Error";
                }
            break;

        case "eliminar":
                if (isset(
                        $post_idbloque,
                        $post_tipo
                    )) {
                    try {
                        $queryVerifyBloque = "SELECT IFNULL(COUNT(*), 0) AS existeBloque FROM bloques WHERE idbloque = ?;";
                        $existeBloque = $f->getQueryData($queryVerifyBloque, [$post_idbloque]);
                        if (!$existeBloque["error"]) {
                            if ($existeBloque["data"][0]["existeBloque"]) {
                                $queryDeleteBloque = "DELETE FROM bloques WHERE idbloque = ?;";
                                $queryData = $f->exeQuery($queryDeleteBloque, [$post_idbloque]);
                                if (!$queryData["error"]) {
                                    $rootPathServer = "/home/administrador/www/html";
                                    $bloqueArchive = ($post_tipo) ? "$rootPathServer/bloques/$post_idbloque.bloque.php" : "$rootPathServer/bloques/$post_idbloque.bloque.html";
                                    $jsArchive = "$rootPathServer/bloques/js/$post_idbloque.script.js";
                                    if (file_exists($jsArchive)) {
                                        if (unlink($jsArchive)) {
                                            if (file_exists($bloqueArchive)) {
                                                if (unlink($bloqueArchive)) {
                                                    $text = "Se eliminó el bloque de manera correcta.";
                                                    $type = "success";
                                                    $title = "success";
                                                }
                                            } else {
                                                $text = "No se encuentra el archivo del bloque que desea eliminar";
                                                $type = "error";
                                                $title = "Error";
                                            }
                                        }
                                    } else {
                                        $text = "No se encuentra el archivo de script que desea eliminar";
                                        $type = "error";
                                        $title = "Error";
                                    }
                                } else {
                                    $text = "Ha ocurrido un error tratando de crear el bloque.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El bloque que usted desea eliminar no existe.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del bloque.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeBloque["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al intentar eliminar el bloque. Para más información contacta con el adminstrador del blog.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No se brindaron los argumentos necesarios para editar el bloque";
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