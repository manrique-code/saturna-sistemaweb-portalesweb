<?php
    global $f;
    global $urlRecursos;
    global $urlSite;

    if ($currentDataUser = $f->usuarioConectado()) {
        if ($f->esAdmin()) {
?>
<a href="#mdl-usuario" class="btn green modal-trigger">Agregar Usuario</a>
<table>
    <thead>
        <tr>
            <th>Codigo Usuario</th>
            <th>Nombre del Usuario</th>
            <th>E-Mail</th>
            <th>Celular</th>
            <th>Super-Administrador</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php


        $modError = false;
        $strsql = "SELECT idusuario, nombre, email, celular, superadministrador, activo FROM usuarios";
        $queryData = $f->getQueryData($strsql);
        if(!$queryData["error"]){
            foreach($queryData["data"] as $usuario){
                $check = '<i class="fas fa-check-circle green-text" style="font-size:20px"></i>';
                $noCheck =  '<i class="fas fa-times-circle red-text" style="font-size:20px"></i>';

                $superadmin = $usuario["superadministrador"] ? $check : $noCheck;
                $estado = $usuario["activo"] ? $check : $noCheck;
    ?>
                <tr>
                    <td><?php echo $usuario["idusuario"];?></td>
                    <td><?php echo $usuario["nombre"];?></td>
                    <td><?php echo $usuario["email"];?></td>
                    <td><?php echo $usuario["celular"];?></td>
                    <td class="center"><?php echo $superadmin;?></td>
                    <td class="center"><?php echo $estado;?></td>
                    <td class="center">
                        <a href="javascript:editarUsuario('<?php echo $usuario["idusuario"];?>')" class="btn blue"><i class="fas fa-edit"></i></a>
                        <a href="javascript:eliminarUsuario('<?php echo $usuario["idusuario"];?>')" class="btn red"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
    <?php
            }
        }
        else{
            $modError = "Error al consultar los usuarios: " . $queryData["error"];
        }
        if($modError){
            echo "<tr><td colspan='7'>$modError</td></tr>";
        }


    ?>
    </tbody>
</table>

<!-- Modal Structure -->
<div id="mdl-usuario" class="modal" style="max-width: 780px;">
    <div class="modal-content">
    <h4 >Agregar Usuario</h4>
    <form class="row" id="frmUsuario">
        <div class="input-field col s12">
          <input placeholder="Codigo del usuario sin espacio ni caracteres especiales" id="txtidusuario" type="text">
          <label for="txtidusuario">Código de Usuario</label>
        </div>

        <div class="input-field col s12">
          <input id="txtnombre" type="text">
          <label for="txtnombre">Nombre del Usuario</label>
        </div>

        <div class="input-field col s12">
          <input id="txtemail" type="email" class="validate">
          <label for="txtemail">E-Mail</label>
        </div>

        <div class="input-field col s12">
          <input id="txtfechanacimiento" type="text">
          <label for="txtfechanacimiento">Fecha Nacimiento</label>
        </div>

        <div class="input-field col s12">
          <input id="txtcelular" type="text">
          <label for="txtcelular">Celular</label>
        </div>

        <div class="input-field col s12">
          <input id="txtpassword" type="password">
          <label for="txtpassword">Password</label>
        </div>

        <div class="col s12 l6 center">
            <label>Administrador</label>
            <div class="switch">
                <label>
                No
                <input type="checkbox" id="chkEsAdmin">
                <span class="lever"></span>
                Si
                </label>
            </div>
        </div>

        <div class="col s12 l6 center">
            <label>Activo</label>
            <div class="switch">
                <label>
                No
                <input type="checkbox" id="chkEstado" checked>
                <span class="lever"></span>
                Si
                </label>
            </div>
        </div>        

    </form>
    </div>
    <div class="modal-footer">
        <a href="javascript:crearUsuario()" class="waves-effect btn green">Guardar</a>
        <a href="#!" class="modal-close waves-effect btn red">Cancelar</a>
    </div>
</div>
<script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
<script src="<?php echo $urlRecursos."/js/materialize.min.js" ?>"></script>
<script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
<?php
        } else {
?>
    <div class="errorAdministrador">
        <img src=<?php echo "$urlRecursos/img/errores/administrator2.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>¿Qué hacés aquí?, tu usuario no tiene los permisos de superadministrador para realizar esta accion</h2>
    </div>
<?php
        }
    } else {
?>
    <div class="errorAdministrador">
        <img src=<?php echo "$urlRecursos/img/errores/administrator2.png"?> style="heigth: 200px; width: 200px"alt="">
        <h2>Inicia sesión para poder disfrutar el contenido de Saturna</h2>
    </div>
<?php
    }
?>