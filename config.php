<?php
    define('DB_SERVER', 'localhost');
    define('DB_NAME', 'eventosuas');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $conexion = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conexion == false){
        die('ERROR: No fue posible conectarse a la DB... ' . mysqli_connect_error());
    }
?>