<?php
session_start();
include("../Layout/header.php");
require_once("../DB_CFG/index.php");
require_once("../Functions/is_valid_record.php");
require_once("../Functions/Strings.php");

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
<center>
    <h1>Hello $FNAME  $MNAME $LNAME</h1>
    <a href='./edit_profile/'>User Profile</a>
    ";
    if ($is_admin) {
        echo ("<br><a href='./admin_room/'>[ADMIN ROOM]</a><br>");
    }
    echo"
    
    <div class ='card'>
    <br>
    <div class='card-body'>
    <a href='./personal_information/'>General Information</a>
    <br>

    <a href='./children/'>[children]</a>
    <br>

    <a href='./civilservice_eligibility/'>[civilservice_eligibility]</a>
    <br>

    <a href='./education/'>[education]</a><br>
    <a href='./learning_and_development/'>[learning_and_development]</a>
    <br>

    <a href='./refference/'>[refference]</a>
    <br>

    <a href='./voluntary_work/'>Voluntary Works</a>
    <br>

    <a href='./works/'>Work Experiences</a>
    <br> 

    </div>   
    <br>
    </center>
    
    <center>
";

echo "
<form action='' method='POST'>
<input type='submit' name='LOGOUT' value='LOG OUT'>
</form>
</center>
</body>
</html>
";

$stmt->free_result();
$stmt->close();

} else {
    header("location: ../");
}
include("../Layout/footer.php");
?>