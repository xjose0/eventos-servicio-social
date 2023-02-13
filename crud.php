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
            $_SESSION['facultad_usuario'] = $facultad_usuario2; //Nombre
            $_SESSION['facultad'] = $facultad_usuario;          //Numero
            header("location: dashboard.php");
        } else{
            $_SESSION['incorrectos'] = 1;
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

    //==============================AGREGAR SEDE==============================
    if(isset($_POST['btnAgregarSede'])){

        $nombre = $_POST['nombreSede'];
        $capacidad = $_POST['capacidadSede'];
        $facultad = $_POST['facultadSede'];

        $sqlinsert = "INSERT INTO sedes (nombre, capacidad, facultad) VALUES ('$nombre', '$capacidad', '$facultad')";

        if($conexion->query($sqlinsert)){
            $_SESSION['sedeAgregada'] = 1;
            header('location: dashboard.php?contenido=sedes.php');
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }

    //==============================MODIFICAR SEDE==============================
    if(isset($_POST['btnModificarSede'])){

        $id = $_POST['id_sede'];
        $nombre = $_POST['nombre'];
        $capacidad = $_POST['capacidad'];

        $sqlupdate = "UPDATE sedes SET nombre = '$nombre', capacidad = '$capacidad' WHERE id_sede='$id'";

        if($conexion->query($sqlupdate)){
            $_SESSION['sedeModificada'] = 1;
            header("location: dashboard.php?contenido=sedes.php");
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }

    //==============================ELIMINAR SEDE==============================
    if(isset($_POST['btnEliminarSede'])){

        $id = $_POST['idEliminar'];

        $sqldelete = "DELETE FROM sedes WHERE id_sede='$id'";

        if($conexion->query($sqldelete)){
            $_SESSION['sedeEliminada'] = 1;
            header('location: dashboard.php?contenido=sedes.php');
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }

    //==============================AGREGAR PROGRAMA==============================
    if(isset($_POST['btnAgregarPrograma'])){

        $nombre = $_POST['nombrePrograma'];

        $sqlinsert = "INSERT INTO programas (nombre) VALUES ('$nombre')";

        if($conexion->query($sqlinsert)){
            $_SESSION['programaAgregado'] = 1;
            header('location: dashboard.php?contenido=programas.php');
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }

    //==============================MODIFICAR PROGRAMA==============================
    if(isset($_POST['btnModificarPrograma'])){

        $id = $_POST['id_programa'];
        $nombre = $_POST['nombre'];

        $sqlupdate = "UPDATE programas SET nombre = '$nombre' WHERE id_programa='$id'";

        if($conexion->query($sqlupdate)){
            $_SESSION['programaModificado'] = 1;
            header("location: dashboard.php?contenido=programas.php");
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }

    //==============================ELIMINAR PROGRAMA==============================
    if(isset($_POST['btnEliminarPrograma'])){

        $id = $_POST['idEliminar'];

        $sqldelete = "DELETE FROM programas WHERE id_programa='$id'";

        if($conexion->query($sqldelete)){
            $_SESSION['programaEliminado'] = 1;
            header('location: dashboard.php?contenido=programas.php');
        } else{
            echo "Error: " . mysqli_error($miServer->conn);
        }

    }
?>