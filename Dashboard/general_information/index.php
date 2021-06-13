<?php
session_start();
require_once("../../DB_CFG/index.php");

if (isset($_SESSION["uuid"])) {

    $sql_field_names = array(
        'first_name',
        'middle_name',
        'surname',
        'name_extension',
        'citizenship',
        'civil_status',
        'gender',
        'birth_date',
        'place_of_birth',
        'height',
        'weight',
        'blood_type'
    );
    
    $stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). " FROM personal_information WHERE user_uuid=?");
 
    $stmt->bind_param("s", $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    
    $stmt->bind_result( 'first_name',
    $middle_name,
    $surname,
    $name_extension,
    $citizenship,
    $civil_status,
    $gender,
    $birth_date,
    $place_of_birth,
    $height,
    $weight,
    $blood_type);
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
        }
            echo "<center>";
        
}




?>