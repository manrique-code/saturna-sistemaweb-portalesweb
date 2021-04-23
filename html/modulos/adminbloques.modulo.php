<?php 
global $f;
global $urlRecursos;
global $urlSite;
    if ($currentUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
            
            $currentUserId = $currentUserData["idusuario"];
            $currentUserName = $currentUserData["nombre"];
            $serverPath = $_SERVER["DOCUMENT_ROOT"];

            $queryGetAllBlocks = "SELECT * FROM bloques";
            $bloques = $f->getQueryData($queryGetAllBlocks, []);
            if (!$queryData["error"]) {
?>
            <h2>Los bloques del blog.</h2>
            <div class="header-bloques-information">
                <a href="<?php echo "$urlSite/?mod=adminbloque&accion=nuevo"; ?>" class="btn-crear-bloque" id="btnCrearBloque">Crear un nuevo bloque</a>
                <p id="cantidadBloques"><?php 
                    $queryCantidadBloques = "SELECT COUNT(*) as cantidad FROM bloques;";
                    $cantidadBloques = $f->getQueryData($queryCantidadBloques, []);
                    echo (!$cantidadBloques["error"]) ? "Hay ".$cantidadBloques["data"][0]["cantidad"]." bloques." : "Error al consultar la cantidad de bloques.";
                ?></p>
            </div>
<?php       
                $contador = 0;
                foreach ($bloques["data"] as $bloque) {
                    $idbloque = $bloque["idbloque"];
                    $bloqueName = $bloque["bloque"];
                    $tipo = $bloque["tipo"];
                    $mostrartitulo = $bloque["mostrartitulo"];
                    $contador++;
?>
                <div class="bloques-container" id="<?php echo "bloque$contador"; ?>" data-bloque="<?php echo "$idbloque"; ?>">
                    <p id="<?php echo "txtNumBloque$idbloque"; ?>" class="txt-cantidad-bloques"><?php echo "$contador"; ?></p>
                    <div class="informacion-bloque">
                        <h2 id="<?php echo "titleBloque$idbloque"; ?>" class="title-bloque"><?php echo "$bloqueName"; ?></h2>
                        <p class="id-bloque" id="<?php echo "idBloque$idbloque"; ?>"><?php echo "$idbloque"; ?></p>
                    </div>
                    <div class="acciones-bloque">
                        <a href="<?php echo "$urlSite/?mod=adminbloque&accion=editar&bloque=$idbloque"; ?>"><i class="fas fa-pencil-alt"></i></a>
                        <a href="<?php echo "javascript:eliminar('$idbloque', $tipo)";?>"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
<?php
                }
?>
<script src=<?php echo "$urlRecursos/js/ckeditor.js"; ?>></script>
            <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js"; ?>"></script>
            <script src="<?php echo $urlRecursos."/js/jquery.min.js"; ?>"></script>
            <script src=<?php echo "$urlRecursos/js/src-noconflict/ace.js";?> type="text/javascript" charset="utf-8"></script>
            <script >let tipoArchivo = 5;</script>
<?php
            } else {
?>
    <div class="errorData">
        <img src=<?php echo "$urlRecursos/img/errores/error1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>¡Ups! No te enojes, pero... Ha habido un error al consultar los datos de este modulo</h2>
    </div>
<?php
            }
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