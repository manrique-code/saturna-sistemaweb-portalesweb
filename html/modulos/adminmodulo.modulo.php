<?php
    global $f;
    global $urlRecursos;
    global $urlSite;
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
        <a href="javascript:crearModulo()" class="btn-guardar" id="btnGuardarNuevoModulo">Crear módulo</a>
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
                    $mostratituo = $moduloData["data"][0]["mostratitulo"];
                    $contenido = $moduloData["data"][0]["contenido"];
?>
        <div class="modulo-container">
        <h2 class="modulo-title" id="crearModuloTitle">Nuevo módulo</h2>
        <form class="nuevo-modulo-formulario" id="frmNuevoModulo">
            <fieldset>
                <label for="">Código del módulo</label>
                <p>Este código es por el cual el módulo será buscado en la barra de direccion del navegador.</p>
                <p class="previsualizacion" id="previsualizacion">Previsualización: </p>
                <input type="text" id="txtIdModuloNuevoInput" value=<?php echo ; ?> >
                <p id="errorInput" class="error-input"></p>
            </fieldset>
            <fieldset>
                <label for="txtTituloModuloNuevoInput">Titulo del módulo</label>
                <input type="text" id="txtTituloModuloNuevoInput">
                <p class="info-input-titulo-nuevo" id="infoInputTituloNuevo"></p>
            </fieldset>
            <fieldset>
                <select name="" id="cbxEditor">
                    <?php 
                        // verificar el tipo de archivo
                    ?>
                </select>
            </fieldset>
            <fieldset>
                <div id="editorPhp"></div>
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
            <script src=<?php echo "$urlRecursos/js/ckeditor.js"?>></script>
            <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
            <script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
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