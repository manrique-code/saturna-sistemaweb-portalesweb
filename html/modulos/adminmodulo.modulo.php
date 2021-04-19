<?php
    global $f;
    global $urlRecursos;
    global $urlSite;
    global $serverPath;
    if ($currentUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
            $currentUserId = $currentUserData["idusuario"];
            $currentUserName = $currentUserData["nombre"];
            $serverPath = $_SERVER["DOCUMENT_ROOT"];
            $accionModulo = $_GET["accion"];  
            
            switch ($accionModulo) {
                case "nuevo":
?>
    <div class="modulo-container">
        <h2 class="modulo-title" id="crearModuloTitle">Nuevo módulo</h2>
        <form class="nuevo-modulo-formulario" id="frmNuevoModulo">
            <fieldset>
                <label for="">Código del módulo</label>
                <p>Este código es por el cual el módulo será buscado en la barra de direccion del navegador.</p>
                <p class="previsualizacion" id="previsualizacion">Previsualización: </p>
                <input type="text" id="txtIdModuloNuevoInput">
                <p id="errorInput" class="error-input"></p>
            </fieldset>
            <fieldset>
                <label for="txtTituloModuloNuevoInput">Titulo del módulo</label>
                <input type="text" id="txtTituloModuloNuevoInput">
                <p class="info-input-titulo-nuevo" id="infoInputTituloNuevo"></p>
            </fieldset>
            <fieldset>
                <label for="selectTipoModuloNuevo">Tipo de módulo</label>
                <select name="" id="selectTipoModuloNuevo">
                    <?php 
                        // cargar los tipos
                        $queryGetModuleType = "SELECT distinct tipo FROM modulos";
                        $tiposModulo = $f->getQueryData($queryGetModuleType, []);
                        if (!$tiposModulo["error"]) {
                            foreach ($tiposModulo["data"] as $tipoModulo) {?>
                            <option value=<?php echo $tipoModulo["tipo"]; ?>><?php echo ($tipoModulo["tipo"]) ? "PHP": "HTML Estático"; ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </fieldset>
            <fieldset>
                    <div id="btnMostrarUOcultarModulo">
                        <i class="far fa-eye"></i>    
                        <label for="">El módulo será visible.</label>
                    </div>
            </fieldset>
            <fieldset>
                <label for="cbxCrearJavascript">Crear archivo de Javascript de este módulo</label>
                <input type="checkbox" name="" id="cbxCrearJavascript" class="cbx-crear-javascript">
            </fieldset>
        </form>
        <a href=<?php echo "$urlSite/?mod=adminmodulos"; ?> class="btn-cancelar">Cancelar</a>
        <a href=<?php echo "javascript:crearModulo()"?> class="btn-guardar" id="btnGuardarNuevoModulo">Crear módulo</a>
    </div>

<?php
                break;
            case "editar":
                if (isset($_GET["idmodulo"])) $idModuloGET = $_GET["idmodulo"];
                $queryGetModuloData = "SELECT * FROM modulos WHERE idmodulo = ?";
                $moduloData = $f->getQueryData($queryGetModuloData, [$idModuloGET]);
                if (!$moduloData["error"]) {
                    $idmodulo = $moduloData["data"][0]["idmodulo"];
                    $moduloTitle = $moduloData["data"][0]["modulo"];
                    $tipo = $moduloData["data"][0]["tipo"];
                    // $mostratituo = $moduloData["data"][0]["mostratitulo"];
                    $contenido = $moduloData["data"][0]["contenido"];
                    $rootPathServer = "/home/administrador/www/html";
                    $urlArchivoModulo = (intval($tipo)) ? "$rootPathServer/modulos/$idmodulo.modulo.php" : "$rootPathServer/modulos/$idmodulo.modulo.html";
                    $urlArchivoAccion = "$rootPathServer/webservices/acciones/$idmodulo.accion.php";
                    $urlArchivoScript = "$rootPathServer/modulos/js/$idmodulo.script.js";
?>
        <div class="modulo-container">
        <h2 class="modulo-title" id="crearModuloTitle">Nuevo módulo</h2>
        <form class="nuevo-modulo-formulario" id="frmNuevoModulo">
            <fieldset>
                <label for="">Código del módulo</label>
                <p style="display: none;">Este código es por el cual el módulo será buscado en la barra de direccion del navegador.</p>
                <p class="previsualizacion" id="previsualizacion" style="display:none;">Previsualización: </p>
                <input type="text" id="txtIdModuloNuevoInput" value=<?php echo $idmodulo; ?> disabled>
                <p id="errorInput" class="error-input"></p>
            </fieldset>
            <fieldset>
                <label for="txtTituloModuloNuevoInput">Titulo del módulo</label>
                <input type="text" id="txtTituloModuloNuevoInput" value="<?php echo($moduloTitle); ?>">
                <p class="info-input-titulo-nuevo" id="infoInputTituloNuevo"></p>
            </fieldset>
            <fieldset>
                <label for="cbxEditor">Selecciona el archivo a editar</label>
                <select name="" id="cbxEditor">
                    <?php
                        if (file_exists($urlArchivoModulo)) {
                            if ($tipo) {
?> 
                                <option value="modulo"><?php echo "$idmodulo.modulo.php"; ?></option>
<?php
                            } else {
?>
                                <option value="html"><?php echo "$idmodulo.modulo.html"; ?></option>
<?php
                            }
                             
                        }
                        if (file_exists($urlArchivoAccion)) {
?>
                            <option value="accion"><?php echo "$idmodulo.accion.php"; ?></option>
<?php
                        }
                        // INGENIERO: POR MAS QUE INTENTE QUE SE MOSTRARA LA INFORMACION DEL ARCHIVO DE JAVASCRIPT NO PUDE
                        //if (file_exists($urlArchivoScript)) {
?>
                            <!-- <option value="script"><?php echo "$idmodulo.script.js"; ?></option> -->
<?php
                        //}
?>
                </select>
            </fieldset>
            <fieldset>
                <label for="editorPhp">Código</label>
                <div id="editorPhp"></div>
                <div id="editorPhpAccion"></div>
                <div id="editorScript"></div>
                <div id="editorHtml"></div>
            </fieldset>
            <fieldset>
                <div id="btnMostrarUOcultarModulo">
                    <i class="far fa-eye"></i>    
                    <label for="">El módulo será visible.</label>
                </div>
            </fieldset>
        </form>
        <a href=<?php echo "$urlSite/?mod=adminmodulos"; ?> class="btn-cancelar">Cancelar</a>
        <a href="<?php echo "javascript:editarModulo($tipo)"?>" class="btn-guardar" id="btnGuardarNuevoModulo">Guardar</a>
        <script type="text/javascript">
            let dataArchivoModulo = `<?php if (file_exists($urlArchivoModulo)) echo htmlspecialchars(file_get_contents($urlArchivoModulo)); ?>`;
            let dataArchivoAccion = `<?php if (file_exists($urlArchivoAccion)) echo htmlspecialchars(file_get_contents($urlArchivoAccion)); ?>`;
            //let dataArchivoScript = '<?php //if (file_exists($urlArchivoScript)) echo htmlspecialchars(str_replace("'", '"', strval(file_get_contents($urlArchivoScript)))); ?>';
        </script>
<?php
            } else {
?>
    <div class="errorData">
        <img src=<?php echo "$urlRecursos/img/errores/error1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>¡Ups! No te enojes, pero... Ha habido un error al consultar los datos de este modulo</h2>
    </div>
<?php
                }
                break;
            default:
?>
    <h2>Accion no valida</h2>
    <p>Esta acción no es valida</p>
<?php
                break;
          }
?>
            <script src=<?php echo "$urlRecursos/js/ckeditor.js"; ?>></script>
            <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js"; ?>"></script>
            <script src="<?php echo $urlRecursos."/js/jquery.min.js"; ?>"></script>
            <script src=<?php echo "$urlRecursos/js/src-noconflict/ace.js";?> type="text/javascript" charset="utf-8"></script>
            <script src=<?php echo "$urlSite/modulos/js/adminmodulo.script.js"?>></script> 
            <script type="text/javascript">
                editorAccion.setValue( ``);
            </script>
            
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