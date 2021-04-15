<?php
    if(isset($post_operacion)){
        switch($post_operacion){
            case "crear": 
                /**
                 * Los datos que necesitamos
                 * titulo: text
                 * contenido: text
                 * fecha: datetime
                 * estado: 0 o 1
                 * idusuario: el usuario que lo publicó
                 * tags: text
                 */
                if(isset(
                    $post_titulo,
                    $post_contenido,
                    $post_estado,
                    $post_idusuario,
                    $post_tags,
                    $post_categorias
                )){
                    // convertimos los id's de las categorias a arreglos reales porque esto viene adentro de una cadena de texto
                    // $post_categorias = stringToArray($post_categorias);
                    $strSql = "
                        INSERT INTO mod_articulos(
                            titulo,
                            contenido,
                            fecha,
                            estado,
                            idusuario,
                            tags
                        )
                        VALUES(?, ?, now(), ?, ?, ?) 
                    ";
                    $parametros = [
                        $post_titulo,
                        $post_contenido,
                        $post_estado,
                        $post_idusuario,
                        $post_tags
                    ];
                    $queryData = $f->exeQuery($strSql, $parametros);

                    if (!$queryData["error"]) {
                        $currentArticuloId = $queryData["lastid"];
                        
                        array_push($parametros, $post_categorias);
                        array_push($parametros, $currentArticuloId);

                        // obtener los id de los nombres de las categorias, lo que implica que las categorias deben ser unicas
                        $getIdCategoria = "SELECT idcategoria FROM mod_articulos_categorias WHERE categoria = ?";
                        $idCategorias = [];

                        foreach ($post_categorias as $categoria) {
                            $id = $f->getQueryData($getIdCategoria, [$categoria]);
                            array_push($idCategorias, ...$id["data"]);
                        }

                        array_push($parametros, $idCategorias);
                                                
                        // insertamos los datos en las tablas auxiliares.
                        $sqlInsertCategorias = "
                            INSERT INTO mod_articulos_articulocategorias(idarticulo, idcategoria)
                            values(?, ?)
                        ";

                        foreach ($idCategorias as $categoria) {
                            $categoryData = $f->exeQuery($sqlInsertCategorias, [$currentArticuloId, $categoria["idcategoria"]]);
                        }
                        if (!$categoryData["error"]) {
                            $text = "Artículo creado con éxito.";
                            $type = "success";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        } else {
                            $text = $categoryData["error"];
                            $type = "error";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        }
                    } else {
                        $text = $queryData["error"];
                        $type = "error";
                        $title = "Éxito";
                        $datareturn = $parametros;
                    }
                }
                else{
                    $text = "No envio todos los datos necesarios para crear el articulo. Intentelo de nuevo";
                }
                break;
            case "editar":
                if(isset(
                    $post_titulo,
                    $post_contenido,
                    $post_estado,
                    $post_idusuario,
                    $post_tags
                )) {

                    // Verificamos que el artículo existe
                    $queryExisteArticulo = "select ifnull(count(*), 0) as existeArticulo
                                            from mod_articulos
                                            where idarticulo = ?;";

                    $existeArticulo = $f->getQueryData($queryExisteArticulo, [$post_idarticulo]);

                    if ($existeArticulo["data"][0]["existeArticulo"]) {

                        $strSql = "";
                        $parametros = null;
                        if (trim($post_contenido) === "") {
                            $strSql = "
                                UPDATE mod_articulos
                                SET titulo = ?,
                                    fecha = now(),
                                    estado = ?,
                                    idusuario = ?,
                                    tags = ?
                                WHERE idarticulo = ?
                            "; 
                            $parametros = [
                                $post_titulo,
                                $post_estado,
                                $post_idusuario,
                                $post_tags,
                                $post_idarticulo
                            ];
                        } else {
                            $strSql = "
                                UPDATE mod_articulos
                                SET titulo = ?,
                                    contenido = ?,
                                    fecha = now(),
                                    estado = ?,
                                    idusuario = ?,
                                    tags = ?
                                WHERE idarticulo = ?
                            "; 
                            $parametros = [
                                $post_titulo,
                                $post_contenido,
                                $post_estado,
                                $post_idusuario,
                                $post_tags,
                                $post_idarticulo
                            ];
                        }
                        // cambiar los datos del articulo 
                        $queryData = $f->exeQuery($strSql, $parametros);
                        if (!$queryData["error"]) {
                            $text = "Artículo editado con éxito.";
                            $type = "success";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        }

                    } else {
                        $text = "Al parecer el artículo que desea editar no existe. Intenta con otro.";
                        $type = "error";
                        $title = "Éxito";
                        $datareturn = $post_idarticulo;
                    }                    

                } else {
                    $text = "No envio todos los datos necesarios para crear el articulo. Intentelo de nuevo";
                }
                break;
            case "eliminar":
                if (isset($post_idarticulo)) {

                    $queryExisteArticulo = "select ifnull(count(*), 0) as existeArticulo
                                            from mod_articulos
                                            where idarticulo = ?;";

                    $existeArticulo = $f->getQueryData($queryExisteArticulo, [$post_idarticulo]);

                    if ($existeArticulo["data"][0]["existeArticulo"]) {
                        // verificamos si el artículo existe y si es así eliminamos el artículo.
                        $queryEliminarArticulo = "DELETE FROM mod_articulos WHERE idarticulo = ?";
                        $parametros = [$post_idarticulo];
                        $queryData = $f->exeQuery($queryEliminarArticulo, $parametros);

                        if (!$queryData["error"]) {
                            $text = "Artículo eliminado con éxito.";
                            $type = "success";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        } else {
                            $text = "No se ha podido eliminar el artículo: " + $queryData['error'];
                            $type = "error";
                            $title = "Éxito";
                            $datareturn = $parametros;
                        }
                    } else {
                        $text = "Al parecer el artículo que desea eliminar no existe. Intenta con otro.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = $post_idarticulo;
                    }
                } else {
                    $text = "No envio todos los datos necesarios para crear el articulo. Intentelo de nuevo";
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

    // funcion para convertir el texto que viene en el post en un arreglo.
    function stringToArray($text) {
        $c = explode(",", $text);
        $corchetes = ["[", "]", " ", "\""];
        $x = str_replace($corchetes, "", $c);
        return $x;
    }
?>