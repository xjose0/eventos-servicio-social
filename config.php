<?php
    define('DB_SERVER', 'localhost');
    define('DB_NAME', 'eventosuas');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    $conexion = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conexion == false){
        die('ERROR: No fue posible conectarse a la DB... ' . mysqli_connect_error());
    } /*else{
        $sqlselect = "SELECT * FROM sedes";
        $datos = $conexion->query($sqlselect);
        $fila = mysqli_fetch_array($datos);
        print_r($fila);
    }*/

    /*define('DB_SERVER', 'sql205.epizy.com');
    define('DB_NAME', 'epiz_32998907_eventosuas');
    define('DB_USERNAME', 'epiz_32998907');
    define('DB_PASSWORD', 'vid3SF6GPnW');

    $conexion = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($conexion == false){
        die('ERROR: No fue posible conectarse a la DB... ' . mysqli_connect_error());
    } */
?>