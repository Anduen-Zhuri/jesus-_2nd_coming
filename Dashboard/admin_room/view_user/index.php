<?php
session_start();

require_once("../../../DB_CFG/index.php");
require_once("../../../Functions/Strings.php");

if (isset($_SESSION["uuid"]) && isset($_GET['uuid']) && $_GET['uuid']) {
    $stmt = $conn->prepare("SELECT is_admin FROM users WHERE uuid=?");
    $stmt->bind_param("s", $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($is_admin);
    $stmt->fetch();

    if (!$is_admin) {
        header("location: ../../");
    }

    $stmt = $conn->prepare("SELECT first_name, middle_name, last_name, birth_day, birth_place, email FROM users WHERE uuid=?");
    $stmt->bind_param("s", $_GET['uuid']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($FNAME, $MNAME, $LNAME, $BDAY, $BPLACE, $EMAIL);
    $stmt->fetch();

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

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_GET['uuid']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($record_id, $date_from, $date_to, $designation, $status, $monthly_salary, $assignment_place, $LAWOP, $separation_date, $separation_cause);
   
   echo"
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
    <center>
            <table>
                <tr>
                    <th>First name</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Birthday</th>
                    <th>Birth place</th>
                    <th>Email</th>
                </tr>
                <tr>
                    <td>$FNAME</td>
                    <td>$MNAME</td>
                    <td>$LNAME</td>
                    <td>$BDAY</td>
                    <td>$BPLACE</td>
                    <td>$EMAIL</td>
                </tr>
            </table>
            <br>
        ";
        
        if ($stmt->num_rows <= 0) {
        echo "<h2>This user's records are empty</h2>";
    } else {



        echo "
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
                <th>Separation clause</th>
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
                </tr>
                ";
            }
       echo "
            </table>
            <a href='./?uuid=$_GET[uuid]&sort=newest' style='margin-right: 1rem'>Sort by newest</a>
            <a href='./?uuid=$_GET[uuid]&sort=oldest' style='margin-left: 1rem'>Sort by oldest</a>
            <br>
            <br>
        ";
}
    
    echo "
    <a href='../'>ADMIN ROOM</a>
    </center>
    </body>
    </html>
    ";
    
    $stmt->free_result();
    $stmt->close();

} else {
    header("location: ../../");
}
?>