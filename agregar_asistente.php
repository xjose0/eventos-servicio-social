<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    require_once("config.php");

    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $grupo = $_POST['grupo'];
    $facultad = $_SESSION['facultad'];
    $evento = $_SESSION['id_evento'];

    $sqlinsert = "INSERT INTO asistentes (nombre, apellido_paterno, apellido_materno, grupo, facultad, evento) VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$grupo', '$facultad', '$evento')";

    if($conexion->query($sqlinsert)){
        echo True;
    } else{
        echo "Error: " . mysqli_error($miServer->conn);
    }
?>