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