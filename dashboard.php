<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    $logged = $_SESSION['logged'];
    if($logged == 0){
        header('location: login.php');
    }

    if(isset($_GET['contenido'])){
        $contenido = $_GET['contenido'];
    } else{
        $contenido = "bienvenida.php";
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./scss/custom.css">
    <link rel="stylesheet" href="./node_modules/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="./css/style.css">
    <script src="node_modules/fullcalendar/locales/es.js"></script>
    <link href='./node_modules/fullcalendar/main.css' rel='stylesheet' />
    <script src='./node_modules/fullcalendar/main.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                left: 'prevYear,prev,next,nextYear'
            },
            locale: "es",
            views: {
                dayGridMonth: {buttonText: 'Mes'},
                timeGridWeek: {buttonText: 'Semana'},
                timeGridDay: {buttonText: 'Día'}
            }
        });
        calendar.render();
    });
    </script>
    <title>Eventos UAS</title>
</head>

<body>

    <nav class="navbar navbar-dark py-3 navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand px-5 pe-5" href="dashboard.php">Eventos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item pe-5">
                        <a class="nav-link" aria-current="page" href="dashboard.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Calendario</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <form action="crud.php" method="post">
                        <button type="submit" class="btn btn-danger" name="btnCerrarSesion">Cerrar sesion</button>
                    </form>
                </span>
            </div>
        </div>
    </nav>

    <div class="bg-warning py-1">

    </div>

    <div class="shadow-lg rounded-4 m-5 p-4 mt-3 bg-light">
        <?php include_once($contenido); ?>
    </div>

    <footer
        style="background-image: url('./assets/wave.svg'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 238px; margin-top: 110px;"
        class="">

    </footer>

    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>