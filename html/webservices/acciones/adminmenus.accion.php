<?php 

global $f;

if (isset($post_operacion)) {
    switch($post_operacion){
        case "verificar":
            if (isset($post_idmenu)) {
                try {
                    $queryVerifyMenu = "
                        SELECT IFNULL(COUNT(*), 0) as existeMenu
                        FROM menus
                        WHERE menu = ?;
                    ";
                    $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_idmenu]);
                    if (!$existeMenu["error"]) {
                        if (!$existeMenu["data"][0]["existeMenu"]) {
                            $text = "El menú es correcto";
                            $type = "success";
                            $title = "Error";
                        } else {
                            $text = "El menú no es válido. Ya existe";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$post_idmenu];
                        }
                    } else {
                        $text = "Ha habido un error al verificar este menú";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$existeMenu["error"]];
                    }
                } catch (Exception $e) {
                    $text = "Ha ocurrido un error al ejecutar la operacion de verificar. Para más información contancta al administrador del blog.";
                    $type = "error";
                    $title = "Error";
                    $datareturn = [$e];
                }
            } else {
                $text = "No pasaste todos los argumentos necesarios para verificar este menú.";
                $type = "error";
                $title = "Error";
            }
            break;

        case "crear":
                if (isset(
                    $post_menu
                )) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menus
                            WHERE menu = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_menu]);
                        if (!$existeMenu["error"]) {
                            if (!$existeMenu["data"][0]["existeMenu"]) {
                                $queryCreateMenu = "INSERT INTO menus(menu) VALUES(?);";
                                $parametros = [$post_menu];
                                $queryData = $f->exeQuery($queryCreateMenu, $parametros);
                                if (!$queryData["error"]) {
                                    $text = "El menú ha sido creado correctamente.";
                                    $type = "success";
                                    $title = "Ok";
                                } else {
                                    $text = "Ha ocurrido un error intentando crear el menú.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El menú que intentas crear ya existe. Por favor intenta con otro nombre";
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del menú.";
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
                    $text = "No pasate los argumentos necesarios para crear el menú";
                    $type = "error";
                    $text = "Error";
                }
            break;

        case "editar":
                if (isset(
                    $post_menu,
                    $post_idmenu
                )) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menus
                            WHERE idmenu = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_idmenu]);
                        if (!$existeMenu["error"]) {
                            if ($existeMenu["data"][0]["existeMenu"]) {
                                $queryEditMenu = "UPDATE menus SET menu = ? WHERE idmenu = ?;";
                                $parametros = [
                                    $post_menu,
                                    $post_idmenu
                                ];
                                $queryData = $f->exeQuery($queryEditMenu, $parametros);
                                if (!$queryData["error"]) {
                                    $text = "El menú ha sido editado";
                                    $type = "success";
                                    $title = "Ok";
                                } else {
                                    $text = "Ha ocurrido un error al intentar editar el menú.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El menú que desea editar no existe.";
                                $type = "error";
                                $title = "Error";
                                $datareturn = [$existeMenu["error"]];
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del menú.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeMenu["error"]];
                        }
                    } catch (Exception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de editar el menú. Para más información contacta al administrador de este blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No pasaste los argumentos necesarios para editar el menú";
                    $type = "error";
                    $title = "Error";
                }
            break;
            
        case "eliminar":
                if (isset($post_idmenu)) {
                    try {
                        $queryVerifyMenu = "
                            SELECT IFNULL(COUNT(*), 0) as existeMenu
                            FROM menus
                            WHERE idmenu = ?
                        ";
                        $existeMenu = $f->getQueryData($queryVerifyMenu, [$post_idmenu]);
                        if (!$existeMenu["error"]) {
                            if ($existeMenu["data"][0]["existeMenu"]) {
                                $queryDeleteMenu = "DELETE FROM menus WHERE idmenu = ?";
                                $parametros = [$post_idmenu];
                                $queryData = $f->exeQuery($queryDeleteMenu, $parametros);
                                if (!$queryData["error"]) {
                                    $text = "El menú ha sido eliminado";
                                    $type = "success";
                                    $title = "Ok";
                                } else {
                                    $text = "Ha ocurrido un error al intentar eliminar el menú.";
                                    $type = "error";
                                    $title = "Error";
                                    $datareturn = [$queryData["error"]];
                                }
                            } else {
                                $text = "El menú que desea eliminar no existe.";
                                $type = "error";
                                $title = "Error";
                                $datareturn = [$existeMenu["error"]];
                            }
                        } else {
                            $text = "Ha ocurrido un error tratando de verificar la autenticidad del menú.";
                            $type = "error";
                            $title = "Error";
                            $datareturn = [$existeMenu["error"]];
                        }
                    } catch (Exeception $e) {
                        $text = "Ha ocurrido un error al ejecutar la operación de eliminar el menú. Para más información contacta al administrador de este blog";
                        $type = "error";
                        $title = "Error";
                        $datareturn = [$e];
                    }
                } else {
                    $text = "No pasaste los argumentos necesarios para editar el menú";
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