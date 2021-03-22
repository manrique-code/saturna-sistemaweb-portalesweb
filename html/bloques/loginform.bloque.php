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
        <h2>Bienvenido</h2>
        <br>
        <p>Bienvenido <a href="?mod=perfilusuario&idusuario=<?php echo $idusuario?>"><?php echo $nombre?></a></p>
        <br>
        <p class="center">Bienvenido <a href="./logout.php" class="btn red">Salir</a></p>
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