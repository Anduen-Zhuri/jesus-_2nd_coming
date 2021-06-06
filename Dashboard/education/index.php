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

$stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). " FROM education WHERE user_uuid=?");

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
    $F_7
);
$stmt->fetch();

if ($stmt->num_rows > 0) {
    $query_type = "UPDATE";
} else {
    $query_type = "INSERT";
}

if(isset($_POST["SUBMIT"])){
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

?>

<form action='' method='POST'>

<?php

for ($i=0; $i < count($fields); $i++) { 
    eval('$value = $F_'.$i.';');
    echo ("
        <label for='field_$i'>$fields[$i]:</label><br>
        <input type='text' id='field_$i' value='$value' name='field_$i'><br>
    ");
}

?>

<input type='submit' name='SUBMIT' value='SUBMIT'>
</form>
</center>

<?php include('../../Layout/footer.php');?>
