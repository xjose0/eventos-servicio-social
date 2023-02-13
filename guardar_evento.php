<?php

    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    require_once("config.php");

    $data = json_decode(file_get_contents("php://input"));
    
    $title = $data->title;
    $expositor = $data->expositor;
    //$start = $data->start;
    $start = DateTime::createFromFormat('Y-m-d\TH:i', $data->start)->format('Y-m-d H:i:s');
    //$end = $data->end;
    $end = DateTime::createFromFormat('Y-m-d\TH:i', $data->end)->format('Y-m-d H:i:s');
    $tipo_evento->tipo_evento;
    $sede = $data->sede;

    $facultad = $_SESSION['facultad'];

    $query = "INSERT INTO eventos(title, expositor, start, end, tipo_evento, sede, facultad, programa) VALUES ('$title', '$expositor', '$start', '$end', '$tipo_evento', '$sede', '$facultad', '$programa')";

    print_r($query);

    $conexion->query($query)

?>