<?php
session_start();
include("../../Layout/header.php");
require_once("../../DB_CFG/index.php");
require_once("../../Functions/is_valid_record.php");
require_once("../../Functions/Strings.php");
require_once("../../Functions/is_valid_registration.php");

if (isset($_SESSION["uuid"])) {
    $stmt = $conn->prepare("SELECT 
    first_name,
    middle_name,
    last_name,
    birth_day,
    birth_place
    FROM users WHERE uuid=?");
        
        
    $stmt->bind_param("s", $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    
    $stmt->bind_result($FNAME, $MNAME, $LNAME, $BDAY, $BPLACE);
    $stmt->fetch();
    
echo "
<html>
    <head>
        <title>Edit profile</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <center>
            <form method='POST' action=''>
                <label for='Firstname'>First name:</label><br>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-Firstname' value='$FNAME'>
                <br>

                <label for='Middlename'>Middle name: (empty if none)</label><br>
                <input type='text' id='Middlename' name='Middlename' autocomplete='cc-Middlename' value='$MNAME'>
                <br>
                
                <label for='Lastname'>Last name:</label><br>
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-Lastname' value='$LNAME'>
                <br>
                
                <label for='Birthday'>Birthday(mm/dd/yyyy)</label><br>
                <input type='text' id='Birthday' name='Birthday' autocomplete='cc-Birthday' value='$BDAY'>
                <br>
                
                <label for='Birthplace'>Birth place:</label><br>
                <input type='text' id='Birthplace' name='Birthplace' autocomplete='cc-Birthplace' value='$BPLACE'>
                <br><br>

                <input type='submit' value='UPDATE' name='UPDATE'>
            </form>
            <a href='../'>DASHBOARD</a>
        </center>
    </body>
</html>
";

if (isset($_POST["UPDATE"])) {
    $FNAME = $_POST["Firstname"];
    $MNAME = $_POST["Middlename"];
    $LNAME = $_POST["Lastname"];
    $BDAY = $_POST["Birthday"];
    $BPLACE = $_POST["Birthplace"];
    $EMAIL = "RANDOMSTRINGTHATISNTEMPTY";
    $PWD = "RANDOMSTRINGTHATISNTEMPTY";

    $response = json_decode(is_valid_registration($conn, $date_format, $FNAME, $MNAME, $LNAME, $EMAIL, $PWD, $BDAY, $BPLACE), true);

        if($response["is_valid"]){

            $stmt = $conn->prepare(
                "UPDATE users SET
                first_name = ?,
                middle_name = ?,
                last_name = ?,
                birth_day = ?,
                birth_place = ? 
                WHERE uuid = ?"
                ) or die('prepare() failed: ' . htmlspecialchars($conn->error));
        
                $stmt->bind_param(
                "ssssss",
                $FNAME,
                $MNAME,
                $LNAME,
                $BDAY,
                $BPLACE,
                $_SESSION["uuid"]
                ) or die('bind() failed: ' . htmlspecialchars($conn->error));

                $stmt->execute();
                $stmt->close();
        
            header("location: ../");
        } else {
            $errors = $response["errors"];
            echo "<center>";

            for ($i=0; $i < count($errors); $i++) { 
                echo "$errors[$i]<br>";
            }

            echo "<center>";
        }
    }

} else {
    header("location: ../");
}
include("../../Layout/footer.php");
?>