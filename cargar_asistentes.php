<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    require_once("config.php");

    $id = $_SESSION['id_evento'];
    $sqlselect = "SELECT * FROM asistentes WHERE evento = '$id'";
    $datos = $conexion->query($sqlselect);
    $asistentes = array();

    while ($fila = mysqli_fetch_array($datos)){
        $asistentes[] = array(
            'id' => $fila['id_asistente'],
            'nombre' => $fila['nombre'] . " " . $fila['apellido_paterno'] . " " . $fila['apellido_materno'],
            'grupo' => $fila['grupo']
        );
    }

    echo json_encode($asistentes);

?>