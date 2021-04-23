<?php 
global $f;
global $urlRecursos;
global $urlSite;
    if ($currentUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
            
            $currentUserId = $currentUserData["idusuario"];
            $currentUserName = $currentUserData["nombre"];
            $serverPath = $_SERVER["DOCUMENT_ROOT"];
            $accion = (isset($_GET["accion"])) ? $_GET["accion"]: "" ;
            switch ($accion){
                case "nuevo":
?>
        <h2>Crear un nuevo bloque</h2>
        <form action="">
            <fieldset>
                <label for="txtIdbloque">Código del bloque</label>
                <input type="text" id="txtIdbloque">
                <p style="margin: 0px;" id="infoTxtIdBloque"></p>
            </fieldset>
            <fieldset>
                <label for="txtBloqueName">Título del bloque</label>
                <input type="text" id="txtBloqueName">
            </fieldset>
            <fieldset>
                <label for="cboTipoArchivo">Elige el tipo de archivo</label>
                <select name="" id="cboTipoArchivo">
                    <option value="1">Archivo PHP</option>
                    <option value="0">Archivo HTML Estático</option>
                </select>
            </fieldset>
            <div class="show-title" id="showTitleButton">
                <p>Mostrar titulo del bloque</p>
            </div>
            <fieldset><label for="chbxJavascript">Crear archivo de Javascript</label><input type="checkbox" name="" id="chbxJavascript"></fieldset>
        </form>
        <a href="javascript:irMenu(false)" class="btn-cancelar">Cancelar</a>
        <a href="javascript:crear()" class="btn-guardar">Guardar</a>
        <script>let tipoArchivo = 5</script>
<?php
                    break;
                case "editar":
            $idbloque = (isset($_GET["bloque"])) ? $_GET["bloque"]: "" ;
            $querySql = "select * from bloques where idbloque = ?";
            $queryData = $f->getQueryData($querySql, [$idbloque]);
            if (!$queryData["error"]) {
                $bloqueName = $queryData["data"][0]["bloque"];
                $post_tipo = $queryData["data"][0]["tipo"];
                $rootPathServer = "/home/administrador/www/html";
                $bloqueArchive = ($post_tipo) ? "$rootPathServer/bloques/$idbloque.bloque.php" : "$rootPathServer/bloques/$idbloque.bloque.html";
                $jsArchive = "$rootPathServer/bloques/js/$idbloque.script.js";
            }
?>
        <h2>Editar bloque bloque</h2>
        <form action="">
            <fieldset>
                <label for="txtIdbloque">Código del bloque</label>
                <input type="text" id="txtIdbloque" value="<?php echo "$idbloque"; ?>" disabled>
            </fieldset>
            <fieldset>
                <label for="txtBloqueName">Título del bloque</label>
                <input type="text" id="txtBloqueName" value="<?php echo "$bloqueName"; ?>">
            </fieldset>
            <fieldset>
                <label  for="cboTipoArchivo">Elige el tipo de archivo</label>
                <select  name="" id="cboTipoArchivo">
                    <option value="<?php echo ($post_tipo) ? "PHP" : "HTML"; ?>"><?php echo ($post_tipo) ? "Archivo PHP" : "Archivo HTML"; ?></option>
                    <option value="javascript">Archivo de JavaScript</option>
                </select>
            </fieldset>
            <div class="show-title" id="showTitleButton">
                <p>Mostrar titulo del bloque</p>
            </div>
            <fieldset style="display:none;"><label for="chbxJavascript">Crear archivo de Javascript</label><input type="checkbox" name="" id="chbxJavascript"></fieldset>
            <div id="editorPHP"></div>
            <div id="editorHtml"></div>
            <div id="editorJs"></div>
            <script>
                let contenido = `<?php if (file_exists($bloqueArchive)) echo htmlspecialchars(file_get_contents($bloqueArchive))?>`; 
                let tipoArchivo = `<?php echo $post_tipo; ?>`;
                let jscontent = `<?php if (file_exists($jsArchive)) echo htmlspecialchars(file_get_contents($jsArchive))?>`
            </script>
        </form>
        <a href="javascript:irMenu(false)" class="btn-cancelar">Cancelar</a>
        <a href="<?php echo "javascript:editar('$idbloque', $post_tipo)"?>" class="btn-guardar">Guardar</a>
<?php
                    break;
                default:
?>
<?php
                    break;
            }
?>
            <script src=<?php echo "$urlRecursos/js/ckeditor.js"; ?>></script>
            <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js"; ?>"></script>
            <script src="<?php echo $urlRecursos."/js/jquery.min.js"; ?>"></script>
            <script src=<?php echo "$urlRecursos/js/src-noconflict/ace.js";?> type="text/javascript" charset="utf-8"></script>
            <script src=<?php echo "$urlSite/modulos/js/adminbloques.script.js"?>></script> 
<?php
        } else {
?>
    <div class="errorAdministrador">
        <img src=<?php echo "$urlRecursos/img/errores/administrator2.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Tu usuario no tiene los permisos suficientes para realizar estas operaciones</h2>
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