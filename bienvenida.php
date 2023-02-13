<?php
    $facultad = $_SESSION['facultad_usuario'];
    if(isset($_SESSION['vicerrectoria'])) 
    { 
        unset($_SESSION['vicerrectoria']); 
    }

    require_once("config.php");
    $sqlselect = "SELECT * FROM facultades WHERE nombre_corto = '$facultad'";
    $datos = $conexion->query($sqlselect);
    $fila = mysqli_fetch_array($datos);
?>
<div>
    <h3 class="text-center pb-4 border-bottom border-warning">¡Hola <?php echo $_SESSION['nombre_usuario'] ?>! Bienvenido al sistema web para la administración de actividades en eventos académicos institucionales</h3>
    <p>
        <h5 class="text-center">Seleccione una opción para continuar</h5>
    </p>
    <div class="d-flex justify-content-center mt-5">
        <form action="crud.php" method="post" class="">
            <input type="hidden" value="<?php echo $facultad; ?>">
            <button type="submit" class="btn-3d animate__bounceIn me-2" name="btnFacultad" <?php echo "style='background-color: #" . $fila['color_boton'] . "; box-shadow: 0 0.438rem 0 #;" . $fila['color_sombra'] .";'"; ?>><?php echo $fila['nombre_corto']; ?></button>
        </form>
        <form action="crud.php" method="post" class="">
            <input type="hidden" name="btnVicerrectoria" value="vicerrectoria">
            <button type="submit" class="vicerrectoria animate__bounceIn" name="btnVicerrectoria">Vicerrectoria</button>
        </form>
    </div>
</div>
