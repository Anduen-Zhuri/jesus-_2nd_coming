<?php
session_start();
include('../../Layout/header.php');
require_once("../../DB_CFG/index.php");
require_once("../../Functions/SQL/sql_handler.php");

if(!isset($_SESSION["uuid"])){
    header("Location: ../../");
}
?>

<center>
<?php


$fields = array(
    'Level',
    'School',
    'Degree course',
    'Attendance from',
    'Attendance to',
    'Units earned',
    'Graduate year',
    'Awards scholarship'
);

$sql_field_names = array(
    'level',
    'school',
    'degree_course',
    'attendance_from',
    'attendance_to',
    'units_earned',
    'graduate_year',
    'awards_scholarship'
);

$stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). ", education_ID FROM education WHERE user_uuid=?");

$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
    $F_0,
    $F_1,
    $F_2,
    $F_3,
    $F_4,
    $F_5,
    $F_6,
    $F_7,
    $education_id
);

$query_type = "INSERT";

if(isset($_POST["INSERT"])){
    for ($i=0; $i < count($fields); $i++) { 
        $object["$sql_field_names[$i]"] = $_POST["field_$i"];
    }

    $response = onSubmit($conn, $query_type, "education", $sql_field_names, $object, null);

    if($response["is_valid"]){
        header("Location: ./");
    } else {
        if ($response["errors"]) {
            for ($i=0; $i <= count($response["errors"]); $i++) { 
                echo "$response[errors][$i] <br>";
            }
        } else {
            echo "Unknown error!<br>";
        }
    }
}

if(isset($_POST["REMOVE"])){
    $id = $_POST["REMOVE"];

    $stmt = $conn->prepare("SELECT education_ID FROM education WHERE education_ID=? AND user_uuid=?");

    $stmt->bind_param("ss", $id, $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM education WHERE education_ID=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        header("Location: ./");
    }
}

?>
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

<form action='' method='POST'>
<table style='width: fit-content'>
    <tr>
        <th><center>Level</center></th>
        <th><center>School</center></th>
        <th><center>Degree course</center></th>
        <th><center>Attendance from</center></th>
        <th><center>Attendance to</center></th>
        <th><center>Units earned</center></th>
        <th><center>Graduate year</center></th>
        <th><center>Awards scholarship</center></th>
    </tr>
    <tr>
        <td><center><textarea name='field_0' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_1' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_2' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_3' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_4' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_5' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_6' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_7' rows='2' cols='10'></textarea></center></td>
    </tr>
</table>
<input type='submit' name='INSERT' value='INSERT'><br>
</form>

<?php

if ($stmt->num_rows <= 0) {
    echo "<h3>No educations set</h3>";
} else {
    echo "
        <table style='width: fit-content'>
            <tr>
                <th><center>Level</center></th>
                <th><center>School</center></th>
                <th><center>Degree course</center></th>
                <th><center>Attendance from</center></th>
                <th><center>Attendance to</center></th>
                <th><center>Units earned</center></th>
                <th><center>Graduate year</center></th>
                <th><center>Awards scholarship</center></th>
                <th><center>Remove</center></th>
            </tr>
    ";

    while ($stmt->fetch()) {
        echo "
            <tr>
                <td><center>";

                    if (empty($F_0)){
                        echo "-";
                    } else {
                        echo $F_0;
                    }
                    
                    echo "</center></td><td><center>";

                    if (empty($F_1)){
                        echo "-";
                    } else {
                        echo $F_1;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_2)){
                        echo "-";
                    } else {
                        echo $F_2;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_3)){
                        echo "-";
                    } else {
                        echo $F_3;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_4)){
                        echo "-";
                    } else {
                        echo $F_4;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_5)){
                        echo "-";
                    } else {
                        echo $F_5;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_6)){
                        echo "-";
                    } else {
                        echo $F_6;
                    }                    
                    
                    echo "</center></td><td><center>";

                    if (empty($F_7)){
                        echo "-";
                    } else {
                        echo $F_7;
                    }
                
                echo "
                </center></td>
                <td style='align-items: center;'>
                    <center>
                        <form action='' method='POST'>
                            <button type='submit' name='REMOVE' value='$education_id' style='
                                background-color: transparent; border: 0px none; cursor: pointer;
                            '>
                                <img src='../../Img/remove.png' style='width: 2rem; height: 2rem;'>
                            </button>
                        </form>
                    </center>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}
?>

</center>

<?php include('../../Layout/footer.php');?>