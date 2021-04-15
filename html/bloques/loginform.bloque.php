<?php
    global $f;
    global $urlRecursos;
    
    $intentoLogin = false;
    if(isset($_POST["txtIdUsuario"], $_POST["p"])) {
        // echo $_POST["txtIdUsuario"];
        // echo $_POST["p"];
        $intentoLogin = $f->login(
            $_POST["txtIdUsuario"],
            $_POST["p"]
        );
    }
    
    $usuarioConectado = $f->usuarioConectado();
    if($usuarioConectado) {
        $nombre = $usuarioConectado["nombre"];
        $idusuario = $usuarioConectado["idusuario"];
?>
        <form action="" class="login-container">
        <div class="login-input">
            <h2>Bienvenido, <br> <a href="?mod=perfilusuario&idusuario=<?php echo $idusuario?>"><?php echo $nombre?></a></h2>
            <hr class="optionLoginSeparator">
            <div ><a href="./logout.php" class="buttonOptionsOverlay"> <i class="fas fa-cog iconOUt"></i></i> Opciones</a></div>
            <div ><a href="./logout.php" class="buttonLogOutOverlay"> <i class="fas fa-sign-out-alt iconOUt"></i> Cerrar sesión</a></div>
        </div>
        </form>
<?php
    } else {
?>
    <form action="javascript:procesarPassword()" class="login-container" id="frmUserLogin" method="post">
        <div class="login-input">
            <?php
                echo $intentoLogin["error"] ? "<p>".$intentoLogin["error"]."</p>" : "";
            ?>
        </div>
        <div class="login-input">
            <label for="txt-usuario">Usuario</label>
            <input type="text" name="txtIdUsuario" id="txt-usuario" placeholder="Usuario o Email" required>
        </div>
        <div class="login-input">
            <label for="txt-contra">Contraseña</label>
            <input type="password" name="" id="txt-contra" required>
            <input type="hidden" name="p" id="txt-contra-encrypt" >
        </div>
            <button id="btn-login" type="submit" name="action">Login</button>
            <button id="btn-cancelar">Cancelar</button>
    </form>
    <script src="<?php echo $urlRecursos?>/js/sha512.min.js"></script>
<?php
    }
?>