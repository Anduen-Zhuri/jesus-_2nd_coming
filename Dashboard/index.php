<?php

session_start();

require_once("../DB_CFG/index.php");

if(isset($_SESSION["uuid"])){

$stmt = $conn->prepare("SELECT first_name, middle_name, last_name FROM users WHERE uuid=?");
$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($FNAME, $MNAME, $LNAME);
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
        case "from_desc":
            $query .= " ORDER BY date_from DESC";
            $from_desc_img = "desc_active.png";
            break;
        
        case "from_asc":
            $query .= " ORDER BY date_from ASC";
            $from_asc_img = "asc_active.png";
            break;
            
        case "to_desc":
            $query .= " ORDER BY date_to DESC";
            $to_desc_img = "desc_active.png";
            break;
        
        case "to_asc":
            $query .= " ORDER BY date_to ASC";
            $to_asc_img = "asc_active.png";
            break;
    }
}


$stmt = $conn->prepare($query);

$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();  
$stmt->bind_result($record_id, $date_from, $date_to, $designation, $status, $monthly_salary, $assignment_place, $LAWOP, $separation_date, $separation_cause);

echo "
<html>
    <head>
        <title>Dashboard</title>
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
    <h1>Hello $FNAME  $MNAME $LNAME</h1>
    
    <center>
";

if ($stmt->num_rows <= 0) {
    echo "<h2>Your records are empty</h2>";
} else {
    echo "<table>";
        echo "
        <tr>
            <th>
                <div style='display: flex; justify-content: center; align-items: center;'>
                    <div style='flex: 0 0 75%;'>From</div>
                    <div style='flex: 1;'>
                        <a href='./?sort=from_asc'><img src='../Img/$from_asc_img' width='15' height='15'></a>
                        <a href='./?sort=from_desc'><img src='../Img/$from_desc_img' width='15' height='15'></a>
                    </div>
                </div>
            </th>

            <th>
                <div style='display: flex; justify-content: center; align-items: center;'>
                    <div style='flex: 0 0 75%;'>To</div>
                    <div style='flex: 1;'>
                    <a href='./?sort=to_asc'><img src='../Img/$to_asc_img' width='15' height='15'></a>
                    <a href='./?sort=to_desc'><img src='../Img/$to_desc_img' width='15' height='15'></a>
                    </div>
                </div>
            </th>
            
            <th>Designation</th>
            <th>Status</th>
            <th>Monthly salary</th>
            <th>Assignment place</th>
            <th>LAWOP</th>
            <th>Separation date</th>
            <th>Separartion clause</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        ";
        while ($stmt->fetch()) {
            echo "
            <tr>
                <td>".explode("-", $date_from)[1]."-".explode("-", $date_from)[2]."-".explode("-", $date_from)[0]."</td>
                <td>".explode("-", $date_to)[1]."-".explode("-", $date_to)[2]."-".explode("-", $date_to)[0]."</td>
                <td>$designation</td>
                <td>$status</td>
                <td>$monthly_salary</td>
                <td>$assignment_place</td>
                <td>$LAWOP</td>
                <td><center>";
                if($separation_date != "0000-00-00"){
                    echo explode("-", $separation_date)[1]."-".explode("-", $separation_date)[2]."-".explode("-", $separation_date)[0];
                }
                
                echo"
                </center></td>
                <td>$separation_cause</td>
                <td valign='center'><center>
                    <a href='./edit_record/?id=$record_id'>
                        <img src='../Img/edit.png' style='width: 2rem; height: 2rem;'>
                    </a>
                </center></td>
                <td valign='center'><center>
                    <a href='./remove_record/?id=$record_id'>
                        <img src='../Img/remove.png' style='width: 2rem; height: 2rem;'>
                    </a>
                </center></td>
            </tr>
            ";
        }
   echo "</table>";
}

echo "
<a href='./insert_record/'>INSERT NEW RECORD</a>
</center>
</body>
</html>
";

$stmt->free_result();
$stmt->close();
$conn->close();

} else {
    header("location: ../");
}
?>