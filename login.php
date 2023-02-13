<?php
    
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="./css/styleLogin.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Iniciar sesión</title>
</head>
<body>
    
    <?php
        if(isset($_SESSION['incorrectos'])){
    ?>
            <script type="text/javascript">
                Swal.fire({
                icon: 'error',
                title: 'ERROR',
                text: 'Los datos proporcionados son incorrectos',
                })
            </script>
    <?php
            unset($_SESSION['incorrectos']);
        }
    ?>

    <section class="side">
        <img src="./assets/UAS_logo.png" alt="">
    </section>

    <section class="main">
        <div class="login-container">
            <p class="title">Bienvenido</p>
            <div class="separator"></div>
            <p class="welcome-message">Ingresa tus credenciales para acceder al sistema</p>

            <form class="login-form" action="crud.php" method="POST">
                <div class="form-control">
                    <input type="text" placeholder="Usuario" name="usuario">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" placeholder="Contraseña" name="contra">
                    <i class="fas fa-lock"></i>
                </div>

                <button class="submit" name="btnIngresar">Ingresar</button>
            </form>
        </div>
    </section>
    
</body>
</html>