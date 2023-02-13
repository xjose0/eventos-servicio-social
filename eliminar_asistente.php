<?php

    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    
    require_once("config.php");

    $id = $_POST['id'];

    $sqldelete = "DELETE FROM asistentes WHERE id_asistente='$id'";

    if($conexion->query($sqldelete)){
        echo True;
    } else{
        echo "Error: " . mysqli_error($miServer->conn);
    }
?>