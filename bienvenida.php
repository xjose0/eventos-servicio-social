<?php
    if(isset($_SESSION['vicerrectoria'])) 
    { 
        unset($_SESSION['vicerrectoria']); 
    }
?>
<div>
    <h3 class="text-center pb-4 border-bottom border-warning">¡Hola <?php echo $_SESSION['nombre_usuario'] ?>! Bienvenido al sistema web para la administración de actividades en eventos académicos institucionales</h3>
    <p>
        <h5 class="text-center">Seleccione una opción para continuar</h5>
    </p>
    <div class="d-flex justify-content-center mt-5">
        <form action="crud.php" method="post" class="">
            <input type="hidden" value="<?php echo $_SESSION['facultad_usuario'] ?>">
            <button type="submit" class="btn-3d animate__bounceIn me-2" name="btnFacultad"><?php echo $_SESSION['facultad_usuario']; ?></button>
        </form>
        <form action="crud.php" method="post" class="">
            <input type="hidden" name="btnVicerrectoria" value="vicerrectoria">
            <button type="submit" class="vicerrectoria animate__bounceIn" name="btnVicerrectoria">Vicerrectoria</button>
        </form>
    </div>
</div>
