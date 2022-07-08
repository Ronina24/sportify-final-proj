<?php
include "db.php";
include "config.php";

    session_start();
    unset($_SESSION["type"]);
    unset($_SESSION["name"]);
    
    header('Location: ' . URL . 'login.php');
?>