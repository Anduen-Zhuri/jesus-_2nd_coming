<?php

session_start();

require_once("../DB_CFG/index.php");
require_once("../Functions/is_valid_registration.php");
require_once("../Functions/generate_uuid.php");
require_once("../Functions/Strings.php");

if(isset($_SESSION["uuid"])){
    header("location: ../Dashboard/");
} else {

echo "
<html>
    <head>
        <title>Registration</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <center>
            <form method='POST' action=''>
                <label for='Firstname'>First name:</label><br>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-Firstname'>
                <br>

                <label for='Middlename'>Middle name: (empty if none)</label><br>
                <input type='text' id='Middlename' name='Middlename' autocomplete='cc-Middlename'>
                <br>
                
                <label for='Lastname'>Last name:</label><br>
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-Lastname'>
                <br>
                
                <label for='Email'>Email:</label><br>
                <input type='email' id='Email' name='Email' autocomplete='cc-Email'>
                <br>      

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-Password'>
                <br>
                
                <label for='Birthday'>Birthday(mm-dd-yyyy):</label><br>
                <input type='text' id='Birthday' name='Birthday' autocomplete='cc-Birthday'>
                <br>
                
                <label for='Birthplace'>Birth place:</label><br>
                <input type='text' id='Birthplace' name='Birthplace' autocomplete='cc-Birthplace'>
                <br><br>

                <input type='submit' value='REGISTER' name='REGISTER'>
            </form>
            <a href='../'>Back to login</a>
        </center>
    </body>
</html>
";
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