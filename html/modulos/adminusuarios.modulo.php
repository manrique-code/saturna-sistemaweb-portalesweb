<?php
    global $f;
?>

<a href="#mdl-usuario" class="btn green modal-trigger">AGREGAR USUARIO</a>

<table>
    <thead>
        <tr>
            <th>Codigo usuario</th>
            <th>Nombre del usuario</th>
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
            if (!$queryData["error"]){
                foreach($queryData["data"] as $usuario){
                    $check = '<i class="fas fa-check-circle green-text" style="font-size:20px"></i>';
                    $noCheck = '<i class="fas fa-times-circle red-text" style="font-size:20px"></i>';

                    $superadmin = ($usuario["superadministrador"] 
                                    ? $check
                                    : $noCheck);

                    $estado = ($usuario["activo"] 
                                    ? $check
                                    : $noCheck);
        ?>
                <tr>
                    <td><?php echo $usuario["idusuario"];?></td>
                    <td><?php echo $usuario["nombre"];?></td>
                    <td><?php echo $usuario["email"];?></td>
                    <td><?php echo $usuario["celular"];?></td>
                    <td class="center"><?php echo $superadmin;?></td>
                    <td class="center"><?php echo $estado;?></td>
                    <td class="center">
                        <a 
                            href="javascript:editarUsuario('<?php echo $usuario["idusuario"];?>')" 
                            class="btn blue"
                        >
                        <i class="fas fa-edit"></i>
                        </a>
                        <a 
                            href="javascript:eliminarUsuario('<?php echo $usuario["idusuario"];?>')" 
                            class="btn red"
                        >
                        <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
        <?php          
                }
            } else {
                $modError = "Error al consultar los usuarios" . $queryData["error"];
            }


            if($modError){
                echo "<tr><td colspan='7'>$modError</td></tr>";
            }
        ?>
    </tbody>

  
</table>

<!-- Modal Structure -->
<div id="mdl-usuario" class="modal" style="max-width: 780px">
    <div class="modal-content">
    <h4>Agregar usuario</h4>
    <form class="row">

        <div class="input-field col s12">
            <input 
                placeholder="Código del usuario sin espacios ni caracteres especiales" 
                id="txtidusuario" 
                type="text"
            >
            <label for="txtidusuario">Código de usuario</label>
        </div>

        <div class="input-field col s12">
            <input 
                placeholder="Código del usuario sin espacios ni caracteres especiales" 
                id="txtidusuario" 
                type="text"
            >
            <label for="txtidusuario">Nombre del usuario</label>
        </div>
        
        <div class="input-field col s12">
            <input 
                id="txtfechanacimiento" 
                type="date"
            >
            <label for="txtfechanacimiento">Fecha de nacimiento</label>
        </div>

        <div class="input-field col s12">
            <input 
                id="txtemail" 
                type="email"
                class="validate"                
            >
            <label for="txtemail">email</label>
        </div>

        <div class="input-field col s12">
            <input 
                id="txtemail" 
                type="text"
            >
            <label for="txtemail">celular</label>
        </div>

    </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn red">Cerrar</a>
        <a href="#!" class="waves-effect waves-green btn green">Guardar</a>
    </div>
</div>
