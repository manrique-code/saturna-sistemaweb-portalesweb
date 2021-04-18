<?php 
    global $f;
    global $urlRecursos;
    global $urlSite;

    // verificando que se haya inciado sesión
    if ($currentUserData = $f->usuarioConectado()) {
        if($f->esAdmin()) {
            $currentUserId = $currentUserData["idusuario"];
?>
<h2>Todos los artículos.</h2>
<table class="striped">
    <thead>
        <tr>
            <th class="center">Código</th>
            <th class="">Título</th>
            <th class="">Publicado</th>
            <th class="center">Autor</th>
            <th class="center">Ver articulo en inicio</th>
            <th class="center">Modifcar</th>
            <th class="center">Eliminar</th>
        </tr>
    </thead>
    <tbody>
<?php
            $queryArticulos = "SELECT * FROM mod_articulos";
            $articuloData = $f->getQueryData($queryArticulos, []);
            $modError = false;            
            if (!$articuloData["error"]) {
                foreach ($articuloData["data"] as $articulo) {
                    $visible = '<a class="btn-accion-table" href="javascript:ocultarArticulo('.$articulo["idarticulo"].', 0)"><i class="far fa-eye"></i></a>';
                    $noVisible = '<a class="btn-accion-table" href="javascript:ocultarArticulo('.$articulo["idarticulo"].', 1)"><i class="far fa-eye-slash"></i></a>';

                    $iconVisibilidad = $articulo["estado"] ? $visible : $noVisible;
?> 
    <tr id=<?php echo $articulo['idarticulo'];?>>
        <td class="center"><?php echo $articulo["idarticulo"]?></td>
        <td class=""><?php echo $articulo["titulo"]?></td>
        <td class=""><?php 
        // mostrando el tiempo que ha pasado
            $fechaPublicacion = new DateTime($articulo["fecha"]);
            $hoy = new DateTime("now");
            $intervalo = $fechaPublicacion->diff($hoy);
            $intervaloMinutos = $intervalo->format("%i");
            $intervaloHoras = $intervalo->format("%h");
            $intervaloDias = $intervalo->format("%h");
            $intervaloMeses = $intervalo->format("%m");
            $fechas = [
                "minutos: $intervaloMinutos",
                "horas: $intervaloHoras",
                "días: $intervaloDias",
                "meses: $intervaloMeses"
            ];   
            echo $articulo["fecha"]
            // ($intervaloMinutos > 60) ? ($intervaloHoras > 24)  ? ($intervaloDias > 31) ? "Hace $intervaloMeses meses" : "Hace $intervaloDias días" : "Hace $intervaloHoras horas" : "Hace $intervaloMinutos minutos";
        ?></td>
        <td class="center"><?php echo $articulo["idusuario"]?></td>
        <td class="center" id=<?php echo 'visibilidad-'.$articulo["idarticulo"]?>><?php echo $iconVisibilidad?></td>
        <td class="center">
            <a class="btn-accion-table" href=<?php echo "$urlSite/?mod=adminarticulo&accion=editar&articulo=".$articulo["idarticulo"]?>><i class="fas fa-pencil-alt"></i></a>
        </td>
        <td class="center">
            <a class="btn-accion-table" href="javascript:eliminarArticulo('<?php
                echo $articulo["idarticulo"];
            ?>')"><i class="fas fa-trash"></i></a>
        </td>
    </tr>    
<?php
                }
            } else {
            $modError = "Error al consultar los usuarios: " . $queryData["error"];
        }
        if($modError){
            echo "<tr><td colspan='7'>$modError</td></tr>";
        }
?>
    </tbody>
    </table>
    <script src=<?php echo "$urlRecursos/js/ckeditor.js"?>></script>
    <script src="<?php echo $urlRecursos."/js/sweetalert2.min.js" ?>"></script>
    <script src="<?php echo $urlRecursos."/js/jquery.min.js" ?>"></script>
<?php
        } else {
?>

    <h2>¿Qué hacés aquí</h2>
    <p>Este usuario no tiene los permiso suficientes para editar los artículos. Contact al administrador para mas info.</p>
<?php 
    }
}
?>