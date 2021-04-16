<?php 
    global $f;
    global $urlRecursos;
    global $urlSite;

    // evaluamos si el usuario está conectado al servidor
    if ($currentUserData = $f->usuarioConectado()) {
        if($f->esAdmin()) {        
            $currentUserId = $currentUserData["idusuario"];
            $serverPath = $_SERVER["DOCUMENT_ROOT"];
            $accionArticulo = $_GET["accion"];

            switch ($accionArticulo) {
                case "nuevo":
?>
    <h2 id="article-title">Nuevo artículo</h2>
    <div class="usuario-conectado">
        <img src=<?php 
                if (file_exists("$serverPath/uploads/imagenes_usuarios/$currentUserId.png")) {
                    echo "$urlSite/uploads/imagenes_usuarios/$currentUserId.png";
                } else {
                    echo "$urlSite/uploads/imagenes_usuarios/defaultimage.png";
                }
            ?> alt="foto-perfil">
        <p id="txt-idusuario"><?php echo $currentUserId?></p>
    </div>
    <form action="" class="frm-articulo">
        <fieldset>
            <label for="txt-titulo-articulo">Título del artículo</label>
            <input type="text" name="" id="txt-titulo-articulo">
        </fieldset>
        <fieldset>
            <label for="">Categorías</label>

            <!-- 
                calculando la cantidad de categorias
                dependiendo de la cantidad de elementos se mostrará un elemento optimizado para cada uno
            -->
            <?php
                $strSql = "SELECT COUNT(*) as cantidadCategorias FROM mod_articulos_categorias";
                $queryData = $f->getQueryData($strSql, []);
                $cantidadCategorias = $queryData["data"][0]["cantidadCategorias"];
                
                $sqlCategorias = "SELECT * FROM mod_articulos_categorias";
                $queryDataCategorias = $f->getQueryData($sqlCategorias, []);
                if (!$queryDataCategorias["error"]) {

                
            ?>
                <select name="" id="cbo-categorias">
                    <option value="default">Selecciona las categorías a las que pertenece este artículo</option>
                    <?php 
                        foreach ($queryDataCategorias["data"] as $categorias) {
                    ?>
                    <option 
                        value=<?php echo $categorias["categoria"]?> 
                        data-idcategoria=<?php echo $categorias["idcategoria"]?>
                    ><?php echo $categorias["categoria"]?></option>
                    <?php 
                        }
                    ?>
                </select>
            <?php 
                }
            ?>
        </fieldset>
        <div id="tag-categorias">
            <!-- <p>#Hola</p> -->
        </div>
        <fieldset>
            <label for="txt-tags">Etiquetas (para optimizar la busqueda en los metabuscadores)</label>
            <input type="text" id="txt-tags" placeholder="tecnologia, php, javascript">
        </fieldset>
        <label for="editor">Contenido del artículo</label>
        <div id="editor"></div>
        <fieldset id="publicar-checkbox">
            <input type="checkbox" name="" id="cbx-publicar">
            <label for="cbx-publicar">Sí, quiero publicar este artículo en el inicio del blog.</label>
        </fieldset>
    </form>
    <a class="btn-cancelar" href="#">Cancelar</a>
    <a href="javascript:submitData()" class="btn-guardar">Guardar</a>
    <!-- <button onclick=<?php header("location: ./modulos/adminarticulos.modulo.php")?> id="menu">click</button> -->
<?php
                break;
                case "editar":
                    $currentEditArticleId = $_GET["articulo"];

                    // seleccionar la informacion del articulo
                    $queryEditArticulo = "SELECT * FROM mod_articulos WHERE idarticulo = ?";
                    $parametrosEditArticulo = [$currentEditArticleId];
                    $getEditArticuloData = $f->getQueryData($queryEditArticulo, $parametrosEditArticulo);
                    
                    if (!$getEditArticuloData["error"]) {
?>
<!-- accion de editar el articulo -->
    <h2 id="article-title">Editar artículo</h2>
    <div class="usuario-conectado">
        <img src=<?php 
                if (file_exists("$serverPath/uploads/imagenes_usuarios/$currentUserId.png")) {
                    echo "$urlSite/uploads/imagenes_usuarios/$currentUserId.png";
                } else {
                    echo "$urlSite/uploads/imagenes_usuarios/defaultimage.png";
                }
            ?> alt="foto-perfil" id="img-perfil">
        <p id="txt-idusuario"><?php echo $currentUserId?></p>
    </div>
    <form action="" class="frm-articulo">
        <fieldset>
            <label for="txt-editar-articulo">Título del artículo</label>
            <input type="text" name="" id="txt-titulo-articulo" value=<?php echo $getEditArticuloData["data"][0]["titulo"]?>>
        </fieldset>
        <fieldset>
            <label for="">Categorías</label>

            <!-- 
                calculando la cantidad de categorias
                dependiendo de la cantidad de elementos se mostrará un elemento optimizado para cada uno
            -->
            <?php
                $strSql = "SELECT COUNT(*) as cantidadCategorias FROM mod_articulos_categorias";
                $queryData = $f->getQueryData($strSql, []);
                $cantidadCategorias = $queryData["data"][0]["cantidadCategorias"];
                
                $sqlCategorias = "select *
                                    from mod_articulos_categorias
                                    where categoria not in(
                                    select mc.categoria
                                    from mod_articulos ma 
                                    inner join mod_articulos_articulocategorias maac
                                    on ma.idarticulo = maac.idarticulo
                                    inner join mod_articulos_categorias mc
                                    on maac.idcategoria = mc.idcategoria
                                    where ma.idarticulo = ?)";
                $queryDataCategorias = $f->getQueryData($sqlCategorias, [$currentEditArticleId]);
                if (!$queryDataCategorias["error"]) {

                
            ?>
                <select name="" id="cbo-categorias">
                    <option value="default">Selecciona las categorías a las que pertenece este artículo</option>
                    <?php 
                        foreach ($queryDataCategorias["data"] as $categorias) {
                    ?>
                    <option 
                        value=<?php echo $categorias["categoria"]?> 
                        data-idcategoria=<?php echo $categorias["idcategoria"]?>
                    ><?php echo $categorias["categoria"]?></option>
                    <?php 
                        }
                    ?>
                </select>
            <?php 
                }
            ?>
        </fieldset>
        <div id="tag-categorias">
            <!-- <p>#Hola</p> -->
            <?php 
                $queryCategoriasArticulo = "select mc.categoria
                                            from mod_articulos ma 
                                            inner join mod_articulos_articulocategorias maac
                                            on ma.idarticulo = maac.idarticulo
                                            inner join mod_articulos_categorias mc
                                            on maac.idcategoria = mc.idcategoria
                                            where ma.idarticulo = ?";
                $parametros = [$currentEditArticleId];
                $getQueryCategoriasArticulo = $f->getQueryData($queryCategoriasArticulo, $parametros);
                if (!$getQueryCategoriasArticulo["error"]) {
                    foreach ($getQueryCategoriasArticulo["data"] as $categorias) {
?>
                        <p data-nombrecategoria=<?php echo $categorias["categoria"]?> id="tag"><?php echo "#".$categorias["categoria"]?></p>
<?php
                    }
                }
            ?>
        </div>
        <fieldset>
            <label for="txt-tags">Etiquetas (para optimizar la busqueda en los metabuscadores)</label>
            <input type="text" id="txt-tags" placeholder="tecnologia, php, javascript" value=<?php echo "\"".$getEditArticuloData["data"][0]["tags"]."\""?>>
        </fieldset>
        <label for="editor">Contenido del artículo</label>
        <div id="editor"></div>
        <fieldset id="publicar-checkbox">
            <input type="checkbox" name="" id="cbx-publicar" <?php echo ($getEditArticuloData["data"][0]["estado"]) ? "checked": ""?>>
            <label for="cbx-publicar">Sí, quiero publicar este artículo en el inicio del blog.</label>
        </fieldset>
    </form>
    <a class="btn-cancelar" href="#">Cancelar</a>
    <a href="javascript:editArticulo()" class="btn-guardar">Guardar cambios</a>
<?php
                    }
                break;
                default: 
?> 
    <h2>Accion no valida</h2>
    <p>Esta acción no es valida</p>
<?php
                // termina case default.
                break;
            }
?>
<!-- fin del switch case -->
            <script src=<?php echo "$urlRecursos/js/ckeditor.js"?>></script>
            <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
            <script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
<?php
        } else { 
?>
<!-- si el usuario no es de tipo superadministrador -->
    <h2>¿Qué haces aquí?</h2>
    <p>No eres usuario administrador por lo tanto no tienes los permisos necesarios para realizar acciones.</p>
    <p>Contancta con el administrador para más información.</p>
<?php
        }
    } else {
?>
<!-- si el usuario no ha iniciado sesion en el sitio -->
    <h2>Al parecer no has inciado sesión</h2>
    <p>Inicia sesión para poder añadir o editar artículos</p>
<?php
    }
?>