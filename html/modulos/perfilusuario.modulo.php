<?php
    global $f;
    global $urlRecursos;
    global $urlSite;

    $imageFolder = "$urlSite/uploads/imagenes_usuarios/";

    // consultar la informacion del usuario actual
    $srtSql = "SELECT * FROM usuarios WHERE idusuario = ?";
    $currentUserData = $f->usuarioConectado();
    if($currentUserData) {
        $currenUserId = $currentUserData["idusuario"];
        $profileData = $f->getQueryData($srtSql, [$currenUserId]);
        $currentUserName = $profileData["data"][0]["nombre"];
        $currentUserEmail = $profileData["data"][0]["email"];
        $currentUserBirthDate = $profileData["data"][0]["fecha_nacimiento"];
        $currentUserPhone = $profileData["data"][0]["celular"];
        $currentUserIsSuperAdmin = $profileData["data"][0]["superadministrador"];
        $currentUserIsActive = $profileData["data"][0]["activo"];
        $serverPath = $_SERVER["DOCUMENT_ROOT"];
?>
<div class="conf-cuenta">
    <div class="contenedor-foto-perfil">
        <div class="edicion" type="file" id="edicion">
            <i class="fas fa-plus"></i>
        </div>
        <div class="foto-perfil">
            <img src=<?php 
            
                if (file_exists("$serverPath/uploads/imagenes_usuarios/$currenUserId.png")) {
                    echo "$urlSite/uploads/imagenes_usuarios/$currenUserId.png";
                } else {
                    echo "$urlSite/uploads/imagenes_usuarios/defaultimage.png";
                }
            ?> alt="" id="img-perfil">
        </div>
        <input type="file" name="" id="input" accept="image/png, image/jpeg, image/jpg" style="display: none">
    </div>
    <h3><?php echo $currenUserId?></h3>
    <p class="leyenda">Click sobre la imagen para cambiarla. La imágen será redimensionada a 250px por 250px</p>
    <hr>
    <form class="contenedor-info-usuario">
        <div class="user-input active">
            <label for="txt-nombre">Nombre Completo</label>
            <input id="txt-nombre" type="text" value=<?php echo $currentUserName?> onkeyup="getFullName(this.value)">
        </div>
        <div class="user-input">
            <label for="txt-email">Email</label>
            <input id="txt-email" type="text" value=<?php echo $currentUserEmail?>>
        </div>
        <div class="user-input">
            <label for="txt-fecha-nac">Fecha de nacimiento</label>
            <input id="txt-fecha-nac" type="date" value=<?php echo $currentUserBirthDate?>>
        </div>
        <div class="user-input">
            <label for="txt-celular">Celular</label>
            <input id="txt-celular" type="text" value=<?php echo $currentUserPhone?>>
        </div>
        <div class="user-input contra">
            <label for="txt-password">Contraseña</label>
            <input id="txt-password" type="password">
        </div>
        <div class="user-input contra">
            <label for="txt-confirm-password">Confirmar Contraseña</label>
            <input id="txt-confirm-password" type="password">
        </div>   

    </form>
    <button>Cancelar</button>
    <a id="saveData" href="javascript:updateUserProfile()">Guardar</a>
    <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
    <script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
</div>
<?php 
    } else {
?>
<div class="conf-cuenta">
    <h4>Ups, al parecer hay un error.</h4>
    <p>Inicia sesión para poder editar tu perfil.</p>
</div>
<?php }?>