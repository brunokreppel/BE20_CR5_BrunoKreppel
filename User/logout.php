<?php
    session_start();

    unset($_SESSION["user"]);
    unset($_SESSION["adm"]);

    session_unset();
    session_destroy();  

    header("Location: ../index.php");
?>