<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    $_SESSION['id_evento'] = $_POST['id'];
?>