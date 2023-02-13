<?php
    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    require_once("config.php");

    $sqlselect = "SELECT * FROM programas";
    $datos = $conexion->query($sqlselect);
    $sedes = array();

    while ($fila = mysqli_fetch_array($datos)){
        $sedes[] = array(
            'id' => $fila['id_programa'],
            'nombre' => $fila['nombre']
        );
    }

    echo json_encode($sedes);

?>