<?php 
    global $f;
    global $urlRecursos;
    global $urlSite;
    // verificamos si el usuario ha inciado sesión
    if ($currentUserData = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
            $currentUserId = $currentUserData["idusuario"];
            $currentUserName = $currentUserData["nombre"];
            $currentUserEmail = $currentUserData["email"];   
            $queryCantidadModulos = "SELECT COUNT(*) as cantidadModulos FROM modulos";
            $getCantidadModulos = $f->getQueryData($queryCantidadModulos, []);
            $cantidadModulos = $getCantidadModulos["data"][0]["cantidadModulos"];
               
?>
    <h2>Administración de módulos</h2>
    <div class="modulos-information">
        <a href=<?php echo "$urlSite/?mod=adminmodulo&accion=nuevo"; ?> >Crear módulo</a>
        <p class="txt-cantidad-modulos" id="cantidaModulos" data-cantidadModulos=<?php echo strval($cantidadModulos); ?> ><?php echo "Hay $cantidadModulos módulos."; ?></p>
    </div>
    <hr>
    <h4>Módulos de este blog</h4>
    <div class="modulos-container">
<?php
            $queryGetAllModulos = "SELECT * FROM modulos";
            $modulos = $f->getQueryData($queryGetAllModulos, []);
            $contador = 0;
            foreach ($modulos["data"] as $modulo) {
                $idmodulo = $modulo["idmodulo"];
                $modulotitulo = $modulo["modulo"];
                $tipo = ($modulo["tipo"]) ? "PHP" : "HTML Estático";
                $visible = "<a href='javascript:mostrarUOcultar($idmodulo, 0)'><i class='far fa-eye'></i></a>";
                $noVisible = "<a href='javascript:mostrarUOcultar($idmodulo, 1)'><i class='far fa-eye-slash'></i></a>";
                $isVisible = ($modulo["mostrartitulo"]) ? $visible : $noVisible ;
                $contador++;

?>
        <div class="modulo-item" id=<?php echo "moduloItem$idmodulo"; ?> >
            <p class="numero-modulos" id="numeroModulos"><?php echo strval($contador)?></p>
            <div class="informacion-modulo" id=<?php echo "informacionModulo$idmodulo"?>>
                <h7 class="id-modulo"><?php echo $idmodulo; ?></h7>
                <h5 class="modulo-title"><?php echo $modulotitulo; ?></h5>
                <p class="tipo-modulo"><?php echo "Tipo de archivo: $tipo"; ?></p>
                <div class="acciones-modulo">
                    <div class="btn-acciones-modulo">
                        <p>Ver en el blog</p>
                        <?php echo $isVisible; ?>
                    </div>
                    <div class="btn-acciones-modulo">
                        <p>Editar</p>
                        <a href=<?php echo "javascript:editarModulo($idmodulo)" ?>>
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </div>
                    <div class="btn-acciones-modulo">
                        <p>Eliminar</p>
                        <a href=<?php echo "javascript:eliminarModulo($idmodulo)" ?>>
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
<?php
            }
?>
    </div>
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
<!-- el usuario no ha iniciado sesión -->
    <div class="errorLogin">
        <img src=<?php echo "$urlRecursos/img/errores/iniciosesion1.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
    }
?>