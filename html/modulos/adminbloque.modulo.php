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
<?php
                    break;
                case "editar":
?>
        <h2>Editar bloque bloque</h2>
        <form action="">
            <fieldset>
                <label for="txtIdbloque">Código del bloque</label>
                <input type="text" id="txtIdbloque">
            </fieldset>
            <fieldset>
                <label for="txtBloqueName">Título del bloque</label>
                <input type="text" id="txtBloqueName">
            </fieldset>
            <fieldset style="display:none">
                <label  for="cboTipoArchivo">Elige el tipo de archivo</label>
                <select  name="" id="cboTipoArchivo">
                    <option value="1">Archivo PHP</option>
                    <option value="0">Archivo HTML Estático</option>
                </select>
            </fieldset>
            <div class="show-title" id="showTitleButton">
                <p>Mostrar titulo del bloque</p>
            </div>
            <fieldset style="display:none;"><label for="chbxJavascript">Crear archivo de Javascript</label><input type="checkbox" name="" id="chbxJavascript"></fieldset>
            <div id="editorPhp"></div>
            <div id="editorHtml"></div>
        </form>
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