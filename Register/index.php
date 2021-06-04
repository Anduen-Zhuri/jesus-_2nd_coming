<?php

session_start();

require_once("../DB_CFG/index.php");
require_once("../Functions/is_valid_registration.php");
require_once("../Functions/generate_uuid.php");
require_once("../Functions/Strings.php");

if(isset($_SESSION["uuid"])){
    header("location: ../Dashboard/");
} else {
        include('registration.php');
}

if (isset($_POST["REGISTER"])) {
    $FNAME = $_POST["Firstname"];
    $MNAME = $_POST["Middlename"];
    $LNAME = $_POST["Lastname"];
    $EMAIL = $_POST["Email"];
    $PWD = $_POST["Password"];
    $BDAY = $_POST["Birthday"];
    $BPLACE = $_POST["Birthplace"];

    $response = json_decode(is_valid_registration($conn, $date_format, $FNAME, $MNAME, $LNAME, $EMAIL, $PWD, $BDAY, $BPLACE), true);

        if($response["is_valid"] && !$response["user_exists"]){
            $UUID = generate_uuid();
            $PWD = md5($PWD);

            $stmt = $conn->prepare("INSERT INTO users (uuid, first_name, middle_name, last_name, birth_day, birth_place, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $UUID, $FNAME, $MNAME, $LNAME, $BDAY, $BPLACE, $EMAIL, $PWD);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
            $conn->close();


            $_SESSION["uuid"] = $UUID;
            header("location: ../Dashboard/");
        } else if($response["user_exists"]){

            echo ("<center><br>* This user is already taken</center>");

        } else {
            $errors = $response["errors"];
            echo "<center>";

            for ($i=0; $i < count($errors); $i++) { 
                echo "$errors[$i]<br>";
            }

            echo "<center>";
        } 
}

?>