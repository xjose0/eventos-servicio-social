<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    require_once("config.php");

    if(isset($_SESSION['vicerrectoria']) && $_SESSION['vicerrectoria'] == "VICERRECTORIA"){
        $facultad = 3;
    }
    else{
        $facultad = $_SESSION['facultad'];
    }
    
    $sqlselect = "SELECT * FROM sedes WHERE sedes.facultad = $facultad";
    $datos = $conexion->query($sqlselect);
    $sedes = array();

    while ($fila = mysqli_fetch_array($datos)){
        $sedes[] = array(
            'id' => $fila['id_sede'],
            'nombre' => $fila['nombre'],
            'capacidad' => $fila['capacidad'],
        );
    }

    echo json_encode($sedes);

?>