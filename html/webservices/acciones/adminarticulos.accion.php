<?php
    if(isset($post_operacion)){
        switch($post_operacion){
            case "editar": 
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