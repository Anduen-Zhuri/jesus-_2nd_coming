<?php

session_start();

require_once("../../DB_CFG/index.php");
require_once("../../Functions/is_valid_record.php");
require_once("../../Functions/Strings.php");

if (isset($_SESSION["uuid"]) && isset($_GET["id"]) && !empty($_GET["id"])) {
$stmt = $conn->prepare("SELECT 
date_from,
date_to,
designation,
status,
monthly_salary,
assignment_place,
LAWOP,
separation_date,
separation_cause 
FROM jobs WHERE id=? AND user=?");
    
    
$stmt->bind_param("ss", $_GET["id"], $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows <= 0) {
    header("location: ../");
}

$stmt->bind_result($date_from, $date_to, $designation, $status, $monthly_salary, $assignment_place, $LAWOP, $separation_date, $separation_cause);
$stmt->fetch();

echo "
<html>
    <head>
        <title>Edit</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) td {
                border-top-width: 0px;
            }
        </style>
    </head>
    <body>
        <center>
            <form method='POST' action=''>
                <table>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Monthly salary</th>
                        <th>Assignment place</th>
                        <th>LAWOP</th>
                        <th>Separation date</th>
                        <th>Separartion clause</th>
                    </tr>
                    <tr>
                        <td><center><textarea name='date_from' rows='2' cols='10'>$date_from</textarea></center></td>
                        <td><center><textarea name='date_to' rows='2' cols='10'>$date_to</textarea></center></td>
                        <td><center><textarea name='designation' rows='2' cols='10'>$designation</textarea></center></td>
                        <td><center><textarea name='status' rows='2' cols='10'>$status</textarea></center></td>
                        <td><center><textarea name='monthly_salary' rows='2' cols='10'>$monthly_salary</textarea></center></td>
                        <td><center><textarea name='assignment_place' rows='2' cols='10'>$assignment_place</textarea></center></td>
                        <td><center><textarea name='LAWOP' rows='2' cols='10'>$LAWOP</textarea></center></td>
                        <td><center><textarea name='separation_date' rows='2' cols='10'>$separation_date</textarea></center></td>
                        <td><center><textarea name='separation_cause' rows='2' cols='10'>$separation_cause</textarea></center></td>
                    </tr>

                </table>
                <br>
                <input type='submit' value='UPDATE' name='UPDATE'>
                <br>
                <br>
                <a href='../'>DASHBOARD</a>
            </form>
        </center>
    </body>
</html>

";

if(isset($_POST["UPDATE"])){
    $response = json_decode(is_valid_record(
        $conn,
        $date_format,
        $_POST["date_from"],
        $_POST["date_to"],
        $_POST["designation"],
        $_POST["status"],
        $_POST["monthly_salary"],
        $_POST["assignment_place"],
        $_POST["LAWOP"],
        $_POST["separation_date"],
        $_POST["separation_cause"]
    ), true);

    if(!$response["is_valid"]){
        $errors = $response["errors"];
        echo "<center>";

            for ($i=0; $i < count($errors); $i++) { 
                echo "$errors[$i]<br>";
            }

        echo "<center>";
    } else {
        $stmt = $conn->prepare(
        "UPDATE jobs SET
        date_from = ?, 
        date_to = ?, 
        designation = ?, 
        status = ?, 
        monthly_salary = ?, 
        assignment_place = ?, 
        LAWOP = ?, 
        separation_date = ?, 
        separation_cause = ?
        WHERE id = ?"
        );

        $stmt->bind_param(
        "ssssssssss",
        $_POST["date_from"],
        $_POST["date_to"],
        $_POST["designation"],
        $_POST["status"],
        $_POST["monthly_salary"],
        $_POST["assignment_place"],
        $_POST["LAWOP"],
        $_POST["separation_date"],
        $_POST["separation_cause"],
        $_GET["id"]
    );

        $stmt->execute();
        $stmt->close();

        header("location: ../");
    }

}

} else {
    header("location: ../");
}

?>