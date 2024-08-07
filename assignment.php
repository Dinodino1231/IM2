<?php
ob_start();
session_start();
if($_SESSION["role"] == "Regular") {
    header("Location: indexstaff.php");
    exit();
}
if (!isset($_SESSION["session_started"])) {
    $_SESSION["session_started"] = TRUE;
    $_SESSION["showEdit"] = FALSE;
    $_SESSION["showRemove"] = FALSE;
}
if (!isset($_SESSION["SORT"])) {
    $_SESSION["SORT"] = "DESC";
}
if (isset($_GET["date"])) {
    $_SESSION["date"] = $_GET["date"];
}
else {
    $_SESSION["date"] = date("Y-m-d");
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="scrollbarstyles.css">
    
    <style>
        body {
            display: block;
        }
        .remove-row {
            display: <?php
                        if (isset($_SESSION["showRemove"])) {
                            if ($_SESSION["showRemove"] == TRUE) {
                                echo "block";
                            } else {
                                echo "none";
                            }
                        } else {
                            echo "none";
                        }
                        ?>;
        }
        table{
            display: flex;
            position: relative;
            align-items: center;
            justify-content: center;
            margin-top: 120px;
            width: fit-content;
            top: 40px;
            left:50%;
            transform: translate(-50%, 0);
        }
        table th{
            background-color: sandybrown;
        }
        table a{
            color: brown;
        }
        table tr{
            background-color: brown;
            color: wheat;
            text-align: center
        }
        table tr:nth-child(even){
            background-color: wheat;
            color: brown;
        }
        .functionalitybuttons{
            /* border: 1px black solid; */
            top: 100px;
            display: flex;
            /* width: fit-content; */
            justify-content: center;
            align-items: center;
            padding: 10px;
            position: fixed;
            left: 50%;
            transform: translate(-50%, 0);
            z-index: 1;
        }
        .functionalitybuttons button{
            padding: 10px;
            margin-left: 10px;
            margin-right: 10px;
            border-radius: 10px;
            background-color: white;
        }
        .functionalitybuttons input{
            padding: 10px;
            margin-left: 10px;
            margin-right: 10px;
            border-radius: 10px;
        }
        .addattendanceholder{
            display: none;
            width: 100%;
            height: 100vh;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, .5);
            padding: 15px;
            position: fixed;
            z-index: 2;
        }
        .add-attendance{
            position: relative;
            background-color: wheat;
            width: fit-content;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: none;
            border-radius: 20px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.50);
        }
        .add-attendance div{
            border: 1px black solid;
            padding: 15px;
        }
        .add-attendance h4{
            margin: 0;
        }
        .add-attendance-form div{
            display: flex;
        }
        /* table {
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            font-size: 0.9em;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            font-family: "Poppins";
        }


        table th {
            padding: 12px 15px;
        }

        table td {
            padding: 12px 15px;
        }

        table tbody tr {
            border-bottom: 4px solid #dddddd;
        }

        table th {
            background-color: #D2042D;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f3f3f3;

        }

        table tbody tr:last-of-type {
            border-color: #D2042D;
        }

        #editor {
            display: none;
        }

        .table_center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px
        } */
        /* .table-align {
            display: flex;
            justify-content: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }

        .settings {
            display: flex;
            justify-content: center;
        }

        .red {
            background-color: orange;
            color: white;
          
        }

        .green {
            background-color: green;
            color: white;
           
        }

        button.edit {
            background-color: green;
        }

        .button {
            background: #fff;
            padding: 10px 15px;
            color: #34495e;
            font-weight: bolder;
            text-transform: uppercase;
            border-radius: 5px;
            box-shadow: 6px 6px 29px -4px rgba(0, 0, 0, 0.50);
            transition: 0.4s;
        }

        .button-close {
          
        }

        .edit-assignment {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .edit-content {
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 5px;
            box-shadow: 6px 6px 29px -4px rgba(0, 0, 0, 0.50);
            position: relative;
           border: none;
        }

        .edit-content input {
            width: 90%;
            display: block;
            margin: 15px 10px;
            padding: 8px;
            border: none;
            border-bottom: 2px solid red;
        }

        .edit-content select {
            display: block;
            margin: 15px 0;
            padding: 8px;
        }

        .button-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
        } */
        .pageheader{
            position: relative;
            /* border: 1px black solid; */
            top: 140px;
            left: 50%;
            transform: translate(-50%, 0);
            z-index: -1;
        }
        .pageheader h1{
            color: wheat;
            text-align: center;
        }
        .editassignmentholder{
            display: block;
            width: 100%;
            height: 100vh;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, .5);
            padding: 15px;
            position: fixed;
            z-index: 2;
        }
        .edit-assignment{
            position: relative;
            background-color: wheat;
            width: fit-content;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: none;
            border-radius: 20px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.50);
        }
        .edit-assignment div{
            border: 1px black solid;
            padding: 15px;
        }
        .edit-assignment h4{
            margin: 0;
        }
        .edit-assignment-form div{
            display: flex;
        }
    </style>
</head>

<body>
    <div class="functionalitybuttons">
        <a href="assignmentsummarization.php"><button style="width: max-content">SUMMARY</button></a>
        <button onclick="showAdd()" class="green">ADD</button>
        <!-- <form method="post">
            <button id="remover" name="removeButton" value="assignment" class="red">REMOVE</button>
        </form> -->
        <input onkeyup="filterTable()" id="search" type="text" placeholder="Search Assignment...">

        <form method="get" style="display:flex">
            <input type="date" name="date" value="<?php echo $_SESSION["date"] ?>">
            <input type="submit" value="Filter" name="filterAttendance">
        </form>
    </div>
    <div class="pageheader">
        <h1>Branch Assignment</h1>
    </div>
            <?php
            include "addattendance.php";
            include "remove.php";
            include "editassignment.php";
            include "filterattendance.php";
            include "navadmin.php";
            ?>

    </body>
<script src="filtertable.js"></script>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editButton"])) {
    $pageName = $_POST["editButton"];
    if ($_SESSION["showEdit"] == FALSE) {
        $_SESSION["showEdit"] = TRUE;
    } else {
        $_SESSION["showEdit"] = FALSE;
    }
    header("Location:$pageName.php");
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeButton"])) {
    $pageName = $_POST["removeButton"];
    if ($_SESSION["showRemove"] == FALSE) {
        $_SESSION["showRemove"] = TRUE;
    } else {
        $_SESSION["showRemove"] = FALSE;
    }
    header("Location:$pageName.php");
    exit();
}
?>