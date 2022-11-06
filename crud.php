<?php
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    require_once("config.php");

    //==============================INICIAR SESION==============================
    if(isset($_POST['btnIngresar'])){
        $usuario = $_POST['usuario'];
        $contra = $_POST['contra'];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contra = '$contra'";

        $datos = $conexion->query($sql);
        $fila = mysqli_num_rows($datos);

        $informacion = mysqli_fetch_array($datos); //array con la informacion del usuario
        $facultad_usuario = $informacion['facultad'];
        $nombre_usuario = $informacion['nombre'];

        $sqlfacultad = "SELECT facultades.nombre_corto as calname from facultades INNER JOIN usuarios ON facultades.id_facultad = '$facultad_usuario'";

        $datos2 = $conexion->query($sqlfacultad); //consulta para el nombre de la facultad
        $informacion2 = mysqli_fetch_array($datos2);
        $facultad_usuario2 = $informacion2['calname'];


        if($fila){
            $_SESSION['logged'] = 1;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['contra'] = $contra;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['facultad_usuario'] = $facultad_usuario2;
            header("location: dashboard.php");
        } else{
            $_SESSION['type'] = "danger";
            $_SESSION['status'] = "Datos incorrectos";
            header("location: login.php");
        }
    }

    //==============================CERRAR SESION==============================
    if(isset($_POST['btnCerrarSesion'])){

        $_SESSION['logged'] = 0;
        header('location: login.php');

    }


    //==============================PULSAR BOTON FACULTAD==============================
    if(isset($_POST['btnFacultad'])){

        header('location: dashboard.php?contenido=views/calendario.php');

    }

    //==============================PULSAR BOTON VICERRECTORIA==============================
    if(isset($_POST['btnVicerrectoria'])){

        $_SESSION['vicerrectoria'] = "VICERRECTORIA";
        header('location: dashboard.php?contenido=views/calendario.php');

    }
?>