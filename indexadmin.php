<?php
    session_start();
    if($_SESSION["role"] != "Administrator"){
        header("Location: indexstaff.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Mama Flor's Lechon House</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php 
            include "navadmin.php";
            include "dashboardnotif.php";
        ?>
    </body>
</html>