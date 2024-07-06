<?php
if($_SESSION["role"] != "Administrator"){
    header("Location: indexstaff.php");
    exit();
}
?>
<?php
    if(isset($_GET["edit"])){
        $assignmentID = $_GET["edit"];
        $conn = mysqli_connect("localhost","root","","mamaflors");
        if($conn->connect_error){
            die("ERROR". $conn->connect_error);
        }
        else{
            $sql = "SELECT
                        assignment.*,
                        CONCAT(staff.last_name, ', ', staff.first_name, ' ', staff.middle_name) AS 'staff_name'
                    FROM
                        assignment
                        INNER JOIN staff ON assignment.staff_ID = staff.staff_ID
                    WHERE
                        assignment_ID = $assignmentID";
            $result = $conn->query($sql);
            $row = $result->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT
                        *
                    FROM
                        branch
                    WHERE
                        branch_status = 'Active'
            ";
            $result = $conn->query($sql);
            $rowBranch = $result->fetch_all(MYSQLI_ASSOC);
            if(sizeof($row)>0){
                echo'
                    <div id="edit" class="edit-assignment">
                        <button onclick="hideEdit()">Close</button>
                        <form method="post">
                            Staff ID:       <input type="text" name="staffID" value="'.$row[0]["staff_ID"].'" readonly>
                            Staff Name:     <input type="text" name="staffName" value="'.$row[0]["staff_name"].'" readonly>
                            Branch ID:
                            <select name="branchID">
                            ';
                            for($x = 0; $x < sizeof($rowBranch); $x++){
                                echo '
                                    <option value="'.$rowBranch[$x]['branch_ID'].'">'.$rowBranch[$x]['branch_ID'].' '. $rowBranch[$x]['branch_name'].'</option>
                                ';
                            }
                        echo '
                            </select>
                            Time In:        <input type="time" name="timein" value="'.$row[0]['time_in'].'">
                            Time Out:       <input type="time" name="timeout" value="'.$row[0]['time_out'].'">
                            Note:           <input type="text" name="note" value="'.$row[0]["note"].'">
                            Status:
                                <select name="status">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                </select>
                            <input type="submit" value="Update" name="Update">
                        </form>
                    </div>
                ';
            }
        }
        $conn->close();
    }
?>

<?php
    if(isset($_POST["Update"])){
        $branchID = $_POST["branchID"];
        $timein = $_POST["timein"];
        $timeout = $_POST["timeout"];
        $note = $_POST["note"];
        $status = $_POST["status"];

        $conn = mysqli_connect("localhost","root","","mamaflors");
        if($conn->connect_error){
            die("ERROR". $conn->connect_error);
        }
        else{
            $sql = "UPDATE assignment
                    SET
                        branch_ID = '$branchID',
                        time_in = '$timein',
                        time_out = '$timeout',
                        note = '$note',
                        assignment_status = '$status'
                    WHERE assignment_ID = $assignmentID
                    ";
            $conn->query($sql);
        }
        $conn->close();
        header("Location: assignment.php");
        exit();
    }
?>