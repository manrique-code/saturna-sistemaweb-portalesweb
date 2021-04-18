<?php 
global $f;

if (isset($post_operacion)) {
    /*
    * campos de comentarios:
    * idcomentario: bigint autoincrementable
    * idarticulo: bigint
    * respuesta: bigint (para poner si se hace alguna respuesta a algun comentario)
    * titulo: varchar(100)
    * contenido: text
    * idusuario: varchar(20)
    */
    switch($post_operacion){
        case "crear":
            if (isset(
                $post_idarticulo,
                $post_respuesta,
                $post_titulo,
                $post_contenido,
                $post_idusuario
            )) {
                $queryCreateComment = "
                    INSERT INTO mod_articulos_comentarios(
                        idarticulo,
                        respuesta,
                        titulo,
                        contenido,
                        idusuario
                    )
                    VALUES(
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                    );
                ";
                $parameters = [
                    $post_idarticulo,
                    $post_respuesta,
                    $post_titulo,
                    $post_contenido,
                    $post_idusuario
                ];
                $queryData = $f->exeQuery($queryCreateComment, $parameters);
                if (!$queryData["error"]) {
                    $text = "Comentario realizado.";
                    $type = "success";
                    $title = "Ok";
                    $datareturn = [
                        $post_idarticulo,
                        $post_respuesta,
                        $post_titulo,
                        $post_contenido,
                        $post_idusuario
                    ];
                } else {
                    $text = "Ha ocurrido un error. No se pudo crear el comentario, intentelo más tarde.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [
                        $queryData["error"]
                    ];
                }
            } else {
                $text = "Hacen falta argumentos. Por favor asegurate de ingresar los datos que se te solicitan.";
                $type = "error";
                $title = "Error";
                $datareturn = [
                    $post_idarticulo,
                    $post_respuesta,
                    $post_titulo,
                    $post_contenido,
                    $post_idusuario
                ];
            }
            break;
        case "editar":
            if (isset(
                $post_titulo,
                $post_contenido,
                $post_idcomentario
            )) {
                // verificamos si el id del comentario existe
                $queryIdCommentExist = "select ifnull(count(*), 0) as idComentarioExiste
                                        from mod_articulos_comentarios
                                        where idcomentario = ?;";
                $idCommentExist = $f->getQueryData($queryIdCommentExist, [$post_idcomentario]);
                if ($idCommentExist) {
                    $queryEditComment = "
                        UPDATE mod_articulos_comentarios 
                        SET titulo = ?,
                            contenido = ?
                        WHERE idcomentario = ?
                    ";
                    $parameters = [
                        $post_titulo,
                        $post_contenido,
                        $post_idcomentario
                    ];
                    $queryData = $f->exeQuery($queryEditComment, $parameters);
                    if (!$queryData["error"]) {
                        $text = "Comentario editado.";
                        $type = "success";
                        $title = "Ok";
                        $datareturn = [
                            $post_titulo,
                            $post_contenido,
                            $post_idcomentario
                        ];
                    } else {
                        $text = "Ha ocurrido un error. El comentario no se pudo editar, intentelo de nuevo más tarde.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [
                            $queryData["error"]
                        ];
                    }
                } else {
                    $text = "El comentario que desea editar no existe.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [
                        $post_idcomentario
                    ];
                }
            } else {
                $text = "Hacen falta argumentos. Por favor asegurate de ingresar los datos que se te solicitan.";
                $type = "error";
                $title = "Error";
                $datareturn = [
                    $post_idarticulo,
                    $post_respuesta,
                    $post_titulo,
                    $post_contenido,
                    $post_idusuario,
                    $post_idcomentario
                ];
            }
            break;
        case "eliminar":
            if (isset($post_idcomentario)) {
                // verificamos si el id del comentario existe
                $queryIdCommentExist = "select ifnull(count(*), 0) as idComentarioExiste
                                        from mod_articulos_comentarios
                                        where idcomentario = ?;";
                $idCommentExist = $f->getQueryData($queryIdCommentExist, [$post_idcomentario]);
                if ($idCommentExist) {
                    $queryDeleteComment = "DELETE FROM mod_articulos_comentarios WHERE idcomentario = ?";
                    $queryData = $f->exeQuery($queryDeleteComment, [$post_idcomentario]);
                    if (!$queryData["error"]) {
                        $text = "Se eliminó el comentario.";
                        $type = "success";
                        $title = "Ok";
                        $datareturn = [
                            $post_idcomentario
                        ];
                    } else {
                        $text = "Ha ocurrido un error. El comentario no se pudo editar, intentelo de nuevo más tarde.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [
                            $queryData["error"]
                        ];
                    }
                } else {
                    $text = "El comentario que desea editar no existe.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [
                        $post_idcomentario
                    ];
                }
            } else {
                $text = "Hacen falta argumentos. Por favor asegurate de ingresar los datos que se te solicitan.";
                $type = "error";
                $title = "Error";
                $datareturn = [
                    $post_idarticulo,
                    $post_respuesta,
                    $post_titulo,
                    $post_contenido,
                    $post_idusuario,
                    $post_idcomentario
                ];
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