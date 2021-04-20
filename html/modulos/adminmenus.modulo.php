<?php
    global $f;
    global $urlSite;
    global $urlRecursos;
    if ($currenUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
            $queryGetAllMenus = "select * from menus ORDER BY idmenu asc";
            $menus = $f->getQueryData($queryGetAllMenus, []);
?>
            <h2>Administración de menús.</h2>
            <a href="#modal1" data-target="modal1" class="btn-guardar modal-trigger" id="btnCrearMenu">Crear menú</a>
<?php
            foreach ($menus["data"] as $menu) {
                $idmenu = $menu["idmenu"];
                $menuName = $menu["menu"];
?>
                <div class="menublog">
                    <div class="item-header">
                        <h3 id="<?php echo "menu$idmenu"; ?>"><?php echo "$menuName"; ?></h3>
                        <a href="" href="#modal2" data-target="modal2" class="modal-trigger">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="<?php echo "javascript:editarMenu($idmenu, '$menuName')"; ?>">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="">
                            <i class="far fa-trash-alt"></i> 
                        </a>
                    </div>
                    <div class="items-menu" id="<?php echo "itemsMenu$idmenu"; ?>">
<?php
                    $queryGetAllItems = "SELECT * FROM menudetalle WHERE idmenu = ? ORDER BY orden asc";
                    $items = $f->getQueryData($queryGetAllItems, [$idmenu]);
                    foreach ($items["data"] as $item) {
                        $iditem = $item["iditem"];
                        $menuitem = $item["menuitem"];
                        $vinculo = $item["vinculo"];
                        $orden = $item["orden"];
?>
                    <div class="items" id="items">
                        <div id="btn-order">
                            <a href="<?php echo "javascript:subirItem($orden, $iditem)"?>"><i class="fas fa-chevron-down"></i></a>
                            <a href="<?php echo "javascript:bajarItem($orden, $iditem)"?>"><i class="fas fa-chevron-up"></i></a>
                        </div>
                        <div class="item-content" id="itemContent">
                            <div class="edicion-item" id="<?php echo "edicionItem$iditem"; ?>" data-item="<?php echo "$iditem"; ?>">
                                <a href=<?php echo "$urlSite$vinculo"; ?> data-numitem="<?php echo "$orden"; ?>"><?php echo "$menuitem"; ?></a>
                                <input type="text" value=<?php echo "$menuitem"; ?> style="display: none;">
                                <div class="btn-save-cancel">
                                    <a href="javascript:cancelarEdicion()">Cancelar</a>
                                    <a href="<?php echo "javascript:editarItem($iditem)"; ?>">Guardar</a>
                                </div>
                            </div>
                            <div class="acciones-item" id="<?php echo "accionesItem$iditem"; ?>" data-item="<?php echo "$iditem"; ?>">
                                <div class="btn-acciones-menu" id="<?php echo "btnEditarItem$iditem"; ?>" data-item="<?php echo "$iditem"; ?>">
                                    <p>Editar</p>
                                    <a href="<?php echo "javascript:editarItem($iditem)";?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                                <div class="btn-acciones-menu" id="<?php echo "btnEliminarItem$iditem"; ?>" data-item="<?php echo "$iditem"; ?>">
                                    <p>Eliminar</p>
                                    <a href="<?php echo "javascript:eliminarItem($iditem)"; ?>">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
                    }
?>
                    </div>
                    </div>
<?php
            }
?>

    <div id="modal1" class="modal">
        <a href=""><i class="fas fa-times"></i></a>
        <div class="modal-content">
            <h4>Nombre del menú.</h4>
            <input type="text" id="inputCreaMenu">
            <p id="informacionInputCrearMenu"></p>
            <hr>
            <h4>Ítem del menú</h4>
            <p>Los menús deben ser creados con al menos un ítem.</p>
            <input type="text" id="itemMenuName">
            <div class="modal-footer">
                <a href="" class="modal-close btn-cancelar">Cancel</a>
                <a href="javascript:crearMenu()" class="btn-guardar" id="btnGuardarMenu">Guardar</a>
            </div>
        </div>
  </div>

  <div id="modal2" class="modal2">
        <a href=""><i class="fas fa-times"></i></a>
        <div class="modal-content">
            <h4>Item del menu</h4>
            <input type="text" id="inputCrearItem">
            <p id="informacionInputCrearMenu"></p>
            <hr>
            <h4>Ítem del menú</h4>
            <p>Los menús deben ser creados con al menos un ítem.</p>
            <input type="text" id="itemMenuName">
            <div class="modal-footer">
                <a href="" class="modal-close btn-cancelar">Cancel</a>
                <a href="javascript:crearMenu()" class="btn-guardar" id="btnGuardarMenu">Guardar</a>
            </div>
        </div>
  </div>

    <script src="<?php echo $urlRecursos."/js/jquery.min.js"; ?>"></script>
    <script src="<?php echo "$urlRecursos/js/materialize.min.js"?>"></script>
    <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js"; ?>"></script>
<?php
        } else {
?>
    <div class="errorAdministrador">
        <img src=<?php echo "$urlRecursos/img/errores/administrator2.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
        }
    } else {
?>
    <div class="errorLogin">
        <img src=<?php echo "$urlRecursos/img/errores/iniciosesion1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
    }
?>