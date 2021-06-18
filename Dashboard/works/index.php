<?php

session_start();
include("../../Layout/header.php");
require_once("../../DB_CFG/index.php");
require_once("../../Functions/is_valid_record.php");
require_once("../../Functions/Strings.php");

if(isset($_SESSION["uuid"])){
$stmt = $conn->prepare("SELECT first_name, middle_name, last_name, is_admin FROM users WHERE uuid=?");
$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($FNAME, $MNAME, $LNAME, $is_admin);
$stmt->fetch();

if ($stmt->num_rows <= 0) {
    unset($_SESSION["uuid"]);
    header("location: ../");
}

$query ="SELECT 
id,
date_from,
date_to,
designation,
status,
monthly_salary,
assignment_place,
LAWOP,
separation_date,
separation_cause 
FROM jobs WHERE user=?";


$from_desc_img = "desc.png";
$from_asc_img = "asc.png";
$to_desc_img = "desc.png";
$to_asc_img = "asc.png";

if (isset($_GET["sort"])) {
    switch ($_GET["sort"]) {
        case "oldest":
            $query .= " ORDER BY STR_TO_DATE(date_from, '%m-%d-%Y') ASC";
            $from_desc_img = "desc_active.png";
            break;
        
        case "newest":
            $query .= " ORDER BY STR_TO_DATE(date_from, '%m-%d-%Y') DESC";
            $from_asc_img = "asc_active.png";
            break;
    }
}


$stmt = $conn->prepare($query);

$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();  
$stmt->bind_result($record_id, $date_from, $date_to, $designation, $status, $monthly_salary, $assignment_place, $LAWOP, $separation_date, $separation_cause);

if(isset($_POST["INSERT"])){
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
        "INSERT INTO jobs
        (
        user,
        date_from, 
        date_to, 
        designation, 
        status, 
        monthly_salary, 
        assignment_place, 
        LAWOP, 
        separation_date, 
        separation_cause
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
        "ssssssssss",
        $_SESSION["uuid"],
        $_POST["date_from"],
        $_POST["date_to"],
        $_POST["designation"],
        $_POST["status"],
        $_POST["monthly_salary"],
        $_POST["assignment_place"],
        $_POST["LAWOP"],
        $_POST["separation_date"],
        $_POST["separation_cause"],
    );

        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("location: ./");
    }

}

if (isset($_POST["LOGOUT"])) {
    unset($_SESSION["uuid"]);
    header("Location: ../");
}

echo "
<html>
    <head>
        <title>Dashboard</title>
        <meta name='viewport' content='width=device-width'>
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
    ";
    echo"
    <center>
    <form method='POST' action=''>
<table>
    <tr>
        <th><center>From<br>(mm/dd/yyyy)</center></th>
        <th><center>To<br>(mm/dd/yyyy)</center></th>
        <th><center>Designation</center></th>
        <th><center>Status</center></th>
        <th><center>Monthly salary</center></th>
        <th><center>Assignment place</center></th>
        <th><center>LAWOP</center></th>
        <th><center>Separation date<br>(if any)</center></th>
        <th><center>Separation clause<br>(if any)</center></th>
    </tr>
    <tr>
        <td><center><textarea name='date_from' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='date_to' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='designation' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='status' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='monthly_salary' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='assignment_place' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='LAWOP' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='separation_date' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='separation_cause' rows='2' cols='10'></textarea></center></td>
    </tr>
</table>
<input type='submit' value='INSERT NEW RECORD' name='INSERT'>
</form>
";

if ($stmt->num_rows <= 0) {
    echo "<h2>Your records are empty</h2>";
} else {
    echo "<table>";
        echo "
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Designation</th>
            <th>Status</th>
            <th>Monthly salary</th>
            <th>Assignment place</th>
            <th>LAWOP</th>
            <th>Separation date</th>
            <th>Separation clause</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        ";
        while ($stmt->fetch()) {
            echo "
            <tr>
                <td>"; 
                if(preg_match($date_format, $date_from)){
                    echo $date_from;
                } else {
                    echo "<center>-</center>";
                }
                echo "
                </td>
                <td>";
                if(preg_match($date_format, $date_to)){
                    echo $date_to;
                } else {
                    echo "<center>-</center>";
                }
                echo"
                </td>
                <td>$designation</td>
                <td>$status</td>
                <td>$monthly_salary</td>
                <td>$assignment_place</td>
                <td>$LAWOP</td>
                <td>";
                if(!empty($separation_date) && preg_match($date_format, $separation_date)){
                    echo $separation_date;
                } else {
                    echo "<center>-</center>";
                }
                echo"
                </td>
                <td>";
                if(!empty($separation_cause)){
                    echo $separation_cause;
                } else {
                    echo "<center>-</center>";
                }
                echo"
                </td>
                <td valign='center'><center>
                    <a href='../edit_record/?id=$record_id'>
                        <img src='../../Img/edit.png' style='width: 2rem; height: 2rem;'>
                    </a>
                </center></td>
                <td valign='center'><center>
                    <a href='../remove_record/?id=$record_id'>
                        <img src='../../Img/remove.png' style='width: 2rem; height: 2rem;'>
                    </a>
                </center></td>
            </tr>
            ";
        }
   echo "</table>";
}

echo "
<a href='./works?sort=newest' style='margin-right: 1rem'>Sort by newest</a>
<a href='./works?sort=oldest' style='margin-left: 1rem'>Sort by oldest</a>
<br>
<br>

</center>
</body>
</html>
";

$stmt->free_result();
$stmt->close();

} else {
    header("location: ./");
}
include("../../Layout/footer.php");
?>