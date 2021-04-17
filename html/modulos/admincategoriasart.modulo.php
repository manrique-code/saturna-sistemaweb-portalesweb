<?php 
    global $f;
    global $urlRecursos;
    global $urlSite;

    // verificar que el usuario este loggeado y que este sea administrador
    
    if ($currentUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
?>
    <h2>Insertar categorias</h2>
    <div class="categoriaInput" >
        <input type="text" placeholder="Añadir categorías..." id="crearCategoriaInput">
        <p id="errorCrearCategoriaInput"></p>
        <a href="javascript:crearCategoria()" id="btnCrearCategoria">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <hr>
    <!-- <h5>Consideraciones</h5>
    <p>Debe tomar en cuenta que si eliminas una categoría, los artículos pertencientes a esta categoría también se eliminaran. Esto es debido a que no pueden existir <a href="https://es.wikipedia.org/wiki/Integridad_referencial">artículos sin categorías en este blog</a>. Si deseas eliminar una categoría pero no estás seguro contacta con el desarrollador del blog.</p> -->
    <div class="categorias" id="categorias">
<?php 
    // seleccionar todas las categorias de la base de datos.
    $queryGetCategories = "
        SELECT *
        FROM mod_articulos_categorias
        ORDER BY idcategoria;
    ";
    $categorias = $f->getQueryData($queryGetCategories, []);
    $contador = 0;
    if (!$categorias["error"]) {
        foreach ($categorias["data"] as $categoria) {
            $contador++;
?>
            <div class="categoryItem" id=<?php echo "categoryItem".$categoria["idcategoria"].""?> data-categoria=<?php echo $categoria["idcategoria"] ?>>
                <h4 id=<?php echo "categoria-".$categoria["idcategoria"] ?>><?php echo $categoria["idcategoria"]?></h4>
                <input type="text" data-categoria=<?php echo $categoria["idcategoria"]?> id=<?php echo "nombreCategoriaInput".$categoria["idcategoria"].""?> value=<?php echo $categoria["categoria"] ?>>
                <p id=<?php echo "mensajeCategoriaEdicion".$categoria["idcategoria"].""?>></p>
                <a href="">Cancelar</a>
                <a id="btnGuardarEdicionCategoria" href=<?php echo "javascript:editarCategoria(".$categoria["idcategoria"].")"?>>Guardar</a>
                <a href=<?php echo "javascript:eliminarCategoria(".$categoria["idcategoria"].")" ?>><i class="far fa-trash-alt"></i></a>
            </div>

<?php

        }
?>
        </div>
        <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
        <script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
<?php
    } else {
?>
    <div class="errorData">
        <img src=<?php echo "$urlRecursos/img/errores/error1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>¡Ups!, no te enojes. Ha habido un error al consultar los datos</h2>
    </div>
<?php
    }
?>
<?php
        } else {
?>
<!-- El usuario no es administrador -->
    <div class="errorAdministrador">
        <img src=<?php echo "$urlRecursos/img/errores/administrator2.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
        }
?>
    
<?php
    } else {
?>
<!-- El usuario no ha iniciado sesión -->
    <div class="errorLogin">
        <img src=<?php echo "$urlRecursos/img/errores/iniciosesion1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
    }
?>