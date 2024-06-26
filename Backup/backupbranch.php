<!DOCTYPE html>
<html>
    <head>
        <style>
            .add-branch{
                display: none;
            }
            table{
                border-collapse: collapse;
            }
            th, tr{
                border: 1px aqua solid;
            }
            tr:nth-child(even){
                background-color: aqua;
            }
        </style>
    </head>
    <body>
        <a href="index.php">Home</a>
        <br>

        <button onclick="showAddBranch()">ADD</button>
        <button>REMOVE</button>
        <button>EDIT</button>

        <br>

        <?php 
            include "addbranch.php"
        ?>
        </table>

    </body>
    <script>
        function showAddBranch(){
            document.getElementById("add-branch").style.display = "block";
        }

        function hideAddBranch(){
            document.getElementById("add-branch").style.display = "none";
        }
    </script>
</html>

<?php
    $conn = mysqli_connect("localhost","root","","mamaflors");
    if($conn->connect_error){
        die("ERROR". $conn->connect_error);
    }
    else{
        $sql = "SELECT * FROM branch";
        if(isset($_GET["sort"])){
            $sql .= " ORDER BY " .$_GET["sort"];
        }
        $result = $conn->query($sql);
        $row = $result->fetch_all(MYSQLI_ASSOC);
        if(sizeof($row) > 0){
            echo "
            <table>
                <tr>
                    <th></th>
                    <th></th>
                    <th><a href='?sort=branch_ID'>Branch ID</a></th>
                    <th><a href='?sort=branch_name'>Branch Name</a></th>
                    <th><a href='?sort=established_date'>Established Date</a></th>
                    <th><a href='?sort=street_name'>Street Name</a></th>
                    <th><a href='?sort=barangay'>Barangay</a></th>
                    <th><a href='?sort=city'>City</a></th>
                    <th><a href='?sort=province'>Province</a></th>
                    <th><a href='?sort=postal_code'>Postal Code</a></th>
                    <th><a href='?sort=contact_number'>Contact Number</a></th>
                    <th><a href='?sort=branch_status'>Branch Status</a></th>
                </tr>";
            for($x = 0; $x < sizeof($row); $x++){
                echo
                    "<tr>
                        <td>
                            <form method='get'>
                                <input type='hidden' value='".($row[$x]['branch_ID'])."' name='edit'>
                                <button class='edit-product-row' id='edit-product-row$x' type='submit'>EDIT</button>
                            </form>
                        </td>
                        <td><form method='get'>
                                <input type='hidden' value='".($row[$x]['branch_ID'])."' name='remove'>
                                <button class='remove-product' id='remove-product$x'>Remove</button>
                            </form>
                        </td>
                        <td>".$row[$x]['branch_ID']."</td>
                        <td>".$row[$x]['branch_name']."</td>
                        <td>".$row[$x]['established_date']."</td>
                        <td>".$row[$x]['street_name']."</td>
                        <td>".$row[$x]['barangay']."</td>
                        <td>".$row[$x]['city']."</td>
                        <td>".$row[$x]['province']."</td>
                        <td>".$row[$x]['postal_code']."</td>
                        <td>".$row[$x]['contact_number']."</td>
                        <td>".$row[$x]['branch_status']."</td>
                    </tr>";
            }
            echo "</table>";
        }
        else{
            echo "DATABASE EMPTY";
        }
    }
    $conn->close();
?>