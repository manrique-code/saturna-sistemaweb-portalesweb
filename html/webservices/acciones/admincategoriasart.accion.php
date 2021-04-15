<?php 

global $f;

if (isset($post_operacion)) {

    switch($post_operacion){
        case "verificarcategoria":
            if (isset($post_categoria)) {
                // verificamos si la categoria existe
                $queryCategoryExist = "select ifnull(count(*), 0) as existeCategoria
                                        from mod_articulos_categorias
                                        where categoria = ?;";
                $categoryExist = $f->getQueryData($queryCategoryExist, [$post_categoria]);
                if (!$categoryExist["data"][0]["existeCategoria"]) {
                    $text = "La categoría es correcta";
                    $type = "succes";
                    $title = "Error";
                    $datareturn = [true, $post_categoria];
                } else {
                    $text = "Esta categoría ya existe. Intenta con otro nombre.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [false, $post_categoria];
                }
            } 
            break;
        case "crear": 
            if (isset(
                $post_categoria
            )) {                
                $queryCreateCategory = "INSERT INTO mod_articulos_categorias(categoria) VALUES(?)";
                $parameters = [$post_categoria];
                $queryData = $f->exeQuery($queryCreateCategory, $parameters);
                if (!$queryData["error"]) {
                    $text = "Categoría creada con éxito.";
                    $type = "succes";
                    $title = "Éxito";
                    $datareturn = $parameters;    
                } else {
                    $text = "Categoría creada con éxito.";
                    $type = "succes";
                    $title = "Éxito";
                    $datareturn = $parameters;
                }
            } else {
                $text = "Ups! Que no se te olvide ingresar una categoría.";
                $type = "error";
                $title = "Error";
                $datareturn = [];
            }
            break;
        case "editar":
            if (isset(
                $post_idcategoria, 
                $post_categoria
            )) {
                // verificar si el id de la categoria es válido
                $queryVerifyCategoryId = "select ifnull(count(*), 0) as existeCategoria
                                from mod_articulos_categorias
                                where idcategoria = ?;";
                $isCategoryIdCorrect = $f->getQueryData($queryVerifyCategoryId, [$post_idcategoria]);
                if ($isCategoryIdCorrect["data"][0]["existeCategoria"]) {
                    $queryEditarCategoria = "UPDATE mod_articulos_categorias SET categoria = ? WHERE idcategoria = ?";
                    $parameters = [$post_categoria, $post_idcategoria];
                    $queryData = $f->exeQuery($queryEditarCategoria, $parameters);
                    if (!$queryData["error"]) {
                        $text = "Se modificó la categoría correctamente.";
                        $type = "success";
                        $title = "Éxito";
                        $datareturn = [$post_idcategoria, $post_categoria];
                    } else {
                        $text = 'Ha sucedido un error y la categoría no se pudo editar. Intenta de nuevo más tarde.';
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$post_idcategoria, $post_categoria];    
                    }
                } else {
                    $text = "La categoria que se desea editar no existe. No te preocupes, intenta con otra categoría.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$post_idcategoria, $post_categoria];    
                }
            } else {
                $text = "Ups! Que no se te olvide ingresar una categoría.";
                $type = "error";
                $title = "Error";
                $datareturn = [];
            }
            break;
        case "eliminar":
            if (isset($post_idcategoria)) {
                // verificar si la categoría a eliminar existe
                $queryVerifyCategoryId = "select ifnull(count(*), 0) as existeCategoria
                                from mod_articulos_categorias
                                where idcategoria = ?;";
                $isCategoryIdCorrect = $f->getQueryData($queryVerifyCategoryId, [$post_idcategoria]);
                if($isCategoryIdCorrect) {
                    $queryDeleteCategory = "DELETE FROM mod_articulos_categorias WHERE idcategoria = ?";
                    $parameters = [$post_idcategoria];
                    $queryData = $f->exeQuery($queryDeleteCategory, $parameters);
                    if (!$queryData["error"]) {
                        $text = "Se eliminó la categoría correctamente.";
                        $type = "success";
                        $title = "Éxito";
                        $datareturn = [$post_idcategoria];
                    } else {
                        $text = "Ha sucedido un error. No se puede eliminar la categoría.";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$post_idcategoria];    
                    }
                } else {
                    $text = "La categoría que deseas eliminar no existe. Intenta de nuevo más tarde";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$post_idcategoria];
                }
            } else {
                $text = "Ups! Que no se te olvide elegir tu categoría a eliminar.";
                $type = "error";
                $title = "Error";
                $datareturn = [];
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