<?php
function logout()
{
    ob_start();
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

function authenticate()
{
    ob_start();
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "mamaflors");
    $sql = "
    SELECT
        account.*,
        staff.*
    FROM
        account
        INNER JOIN staff ON account.account_ID = staff.staff_ID
    WHERE
        account.account_ID = '" . $_SESSION["account_ID"] . "'
    ";
    $result = $conn->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    if (sizeof($row) > 0 && password_verify($_SESSION["pass"], $row[0]["password"])) {
        if ($row[0]["account_status"] == 'Active') {
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["last_name"] = $row[0]["last_name"];
            $_SESSION["first_name"] = $row[0]["first_name"];
            $_SESSION["middle_name"] = $row[0]["middle_name"];
            $_SESSION["house_number"] = $row[0]["house_number"];
            $_SESSION["street_name"] = $row[0]["street_name"];
            $_SESSION["barangay"] = $row[0]["barangay"];
            $_SESSION["city"] = $row[0]["city"];
            $_SESSION["province"] = $row[0]["province"];
            $_SESSION["postal_code"] = $row[0]["postal_code"];
            $_SESSION["contact_1"] = $row[0]["contact_1"];
            $_SESSION["contact_2"] = $row[0]["contact_2"];
            $_SESSION["email"] = $row[0]["email"];
            $_SESSION["role"] = $row[0]["role"];

            $sql = "
                SELECT
                    branch.branch_ID,
                    branch.branch_name,
                    account.account_ID
                FROM
                    (assignment
                    INNER JOIN branch ON assignment.branch_ID = branch.branch_ID)
                    INNER JOIN account ON assignment.staff_ID = account.account_ID
                WHERE
                    account.account_ID = '" . $_SESSION["account_ID"] . "'
                    AND
                    assignment.assignment_date = CURRENT_DATE
            ";
            $result = $conn->query($sql);
            $row = $result->fetch_all();
            $_SESSION["branch_assigned"] = $row[0]["branch_name"];
            //check for Role in account
            if ($_SESSION["role"] == "Administrator") {
                header("Location: admin.php");
            } else {
                header("Location: staff.php");
            }
            exit();
        }
    }
    $conn->close();
}

if (isset($_GET['logout'])) {
    logout();
}

if (isset($_GET['authenticate'])) {
    authenticate();
}
