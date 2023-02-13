<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    header('content-type: application/Json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');

    $pdo = new PDO("mysql:host=127.0.0.1;dbname=eventosuas", "root", "");

    $accion = (isset($_GET['accion'])) ? $_GET['accion']:'leer';
    $facultad = $_SESSION['facultad'];

    switch($accion){
        case 'agregar':
            if(isset($_SESSION['vicerrectoria']) && $_SESSION['vicerrectoria'] == "VICERRECTORIA"){
                $facultad = 3;
            }
            else{
                $facultad = $_POST['facultad'];
            }
            $sentenciaSQL = $pdo->prepare("INSERT INTO eventos(title, expositor, start, end, tipo_evento, sede, facultad, programa) VALUES (:title, :expositor, :start, :end, :tipo_evento, :sede, :facultad, :programa)");

            $respuesta=$sentenciaSQL->execute (array (
                "title" =>$_POST['title'],
                "expositor" => $_POST['expositor'],
                "start" => $_POST['start'],
                "end" => $_POST['end'],
                "tipo_evento" => $_POST['tipo_evento'],
                "sede" =>$_POST['sede'],
                "facultad" => $facultad,
                "programa" =>$_POST['programa']
            ));
            echo json_encode($respuesta);
            break;
        case 'eliminar':
            $respuesta = false;
            if(isset($_POST['id'])){
                try {
                    $sentenciaSQL = $pdo->prepare("DELETE FROM eventos WHERE id_evento = :id");
                    $respuesta2 = $sentenciaSQL->execute(array(":id" => $_POST['id']));
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
            echo json_encode($respuesta2);
            break;
        case 'modificar':
            $sentenciaSQL = $pdo->prepare("UPDATE eventos SET title = :title, expositor = :expositor, start = :start, end = :end, tipo_evento = :tipo_evento, sede = :sede, programa = :programa WHERE eventos.id_evento = :id");

            $respuesta=$sentenciaSQL->execute (array (
                ":id" => $_POST['id'],
                "title" =>$_POST['title'],
                "expositor" => $_POST['expositor'],
                "start" => $_POST['start'],
                "end" => $_POST['end'],
                "tipo_evento" => $_POST['tipo_evento'],
                "sede" =>$_POST['sede'],
                "programa" =>$_POST['programa']
            ));
            echo json_encode($respuesta);

            break;
        default:
            if(isset($_SESSION['vicerrectoria']) && $_SESSION['vicerrectoria'] == "VICERRECTORIA"){
                $sentenciaSQL = $pdo->prepare("SELECT * FROM eventos WHERE eventos.facultad = :facultad");
                $sentenciaSQL->execute(array(':facultad' => 3));
            }
            else{
                $sentenciaSQL = $pdo->prepare("SELECT * FROM eventos WHERE eventos.facultad = :facultad");
                $sentenciaSQL->execute(array(':facultad' => $facultad));
            }

            $resultado= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
        
            /*foreach ($resultado as &$evento) {
                $evento['start'] = date(DATE_ISO8601, strtotime($evento['start']));
                $evento['end'] = date(DATE_ISO8601, strtotime($evento['start']));
            }*/
        
            echo json_encode($resultado);
    }

?>