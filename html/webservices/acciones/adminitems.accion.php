<?php 

global $f;

if (isset($post_operacion)) {
    switch($post_operacion){
        case "verificar":
            if (isset($post_menuitem)) {
                try {
                    $queryVerifyMenu = "
                        SELECT IFNULL(COUNT(*), 0) as existeItem
                        FROM menudetalle
                        WHERE menuitem = ?;
                    ";
                    $existeItem = $f->getQueryData($queryVerifyMenu, [$post_menuitem]);
                    if (!$existeItem["error"]) {
                        if (!$existeItem["data"][0]["existeItem"]) {
                            $text = "El ítem es correcto";
                            $type = "success";
                            $title = "Ok";
                        } else {
                            $text = "El ítem no es válido. Ya existe";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$post_menuitem];
                        }
                    } else {
                        $text = "Ha habido un error al verificar este ítem";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$existeItem["error"]];
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al ejecutar la operacion de verificar. Para más información contancta al administrador del blog.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$e];
                }
            } else {
                $text = "No pasaste todos los argumentos necesarios para verificar este ítem.";
                $type = "error";
                $title = "Error";
            }
            break;

        case "crear":
                if (isset(
                    $post_idmenu,
                    $post_menuitem,
                    $post_vinculo,
                    $post_orden
                )) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menudetalle
                            WHERE menuitem = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_menuitem]);
                        if (!$existeMenu["error"]) {
                            if (!$existeMenu["data"][0]["existeMenu"]) {
                                $queryVerifyOrderItem = "SELECT MAX(orden) + 1 as siguiente FROM menudetalle WHERE idmenu = ?;";
                                $existeOrden = $f->getQueryData($queryVerifyOrderItem, [$post_idmenu]);
                                if (!$existeOrden["error"]) {
                                    $queryCreateMenu = "INSERT INTO menudetalle(idmenu, menuitem, vinculo, orden) VALUES(?, ?, ?, ?);";
                                    $parametros = [
                                        $post_idmenu,
                                        $post_menuitem,
                                        $post_vinculo,
                                        $existeOrden["data"][0]["siguiente"]
                                    ];
                                    $queryData = $f->exeQuery($queryCreateMenu, $parametros);
                                    if (!$queryData["error"]) {
                                        $text = "El ítem ha sido creado correctamente.";
                                        $type = "success";
                                        $title = "Ok";
                                    } else {
                                        $text = "Ha ocurrido un error intentando crear el ítem.";
                                        $type = "error";
                                        $title = "Error";
                                        $datareturn = [$queryData["error"]];
                                        }                                
                                } else {
                                    $text = "Ha ocurrido un error tratando de verificar el orden de este ítem.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$existeOrden["error"]];
                                }
                            } else {
                                $text = "El ítem que intentas crear ya existe. Por favor intenta con otro nombre";
                                $type = "error";
                                $title = "error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del ítem.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeMenu["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de crear el menú. Para más información, contacta al administrador del blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No pasate los argumentos necesarios para crear el ítem";
                    $type = "error";
                    $text = "Error";
                }
            break;
        
        case "reordenar":
                if (isset(
                    $post_iditem,
                    $post_orden
                )) {
                    try {
                        $queryReordenarItem = "UPDATE menudetalle SET orden = ? WHERE iditem = ?;";
                        $parametros = [$post_orden, $post_iditem];
                        $queryData = $f->exeQuery($queryReordenarItem, $parametros);
                        if (!$queryData["error"]) {
                            $text = "Se ordenó el ítem de manera correcta";
                            $type = "success";
                            $title = "Ok";
                        } else {
                            $text = "Ha ocurrido un error tratando de darle una nueva posición a este ítem.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$queryData["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de reordenar los ítems. Para más información, contacta al administrador del blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No pasate los argumentos necesarios para ordenar el ítem";
                    $type = "error";
                    $text = "Error";
                }
            break;

        case "editar":
                if (isset(
                    $post_iditem,
                    $post_menuitem,
                    $post_vinculo,
                    $post_orden
                )) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menudetalle
                            WHERE iditem = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_iditem]);
                        if (!$existeMenu["error"]) {
                            if ($existeMenu["data"][0]["existeMenu"]) {
                                $queryEditMenu = "UPDATE menudetalle SET menuitem = ?, vinculo = ?, orden = ? WHERE iditem = ?";
                                $parametros = [
                                    $post_menuitem,
                                    $post_vinculo,
                                    $post_orden,
                                    $post_iditem
                                ];
                                $queryData = $f->exeQuery($queryEditMenu, $parametros);
                                if (!$queryData["error"]) {
                                    $text = "Se editó el ítem de manera correcta";
                                    $type = "success";
                                    $title = "Ok";
                                } else {
                                    $text = "Ha ocurrido un error tratando de editar este ítem.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El ítem que deseas editar no existe.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la vercidad de este ítem.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeMenu["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de editar los ítems. Para más información, contacta al administrador del blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e]; 
                    }
                } else {
                    $text = "No pasate los argumentos necesarios para ordenar el ítem";
                    $type = "error";
                    $text = "Error";
                }
            break;
        case "eliminar":
                if (isset($post_iditem)) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menudetalle
                            WHERE iditem = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_iditem]);
                        if (!$existeMenu["error"]) {
                            if ($existeMenu["data"][0]["existeMenu"]) {
                                $queryDeleteItem = "DELETE FROM menudetalle WHERE iditem = ?";
                                $queryData = $f->exeQuery($queryDeleteItem, [$post_iditem]);
                                if (!$queryData["error"]) {
                                    $text = "Ítem eliminado";
                                    $type = "success";
                                    $title = "Ok";
                                } else {
                                    $text = "Ha ocurrido un error al tratar de eliminar este ítem.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El ítem que deseas eliminar no existe.";
                                $type = "error";
                                $title = "Error";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la vercidad de este ítem.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeMenu["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de eliminar los ítems. Para más información, contacta al administrador del blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e]; 
                    }
                } else {
                    $text = "No pasate los argumentos necesarios para ordenar el ítem";
                    $type = "error";
                    $text = "Error";
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