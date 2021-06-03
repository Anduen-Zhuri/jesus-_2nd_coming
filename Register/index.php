<?php

session_start();

require_once("../DB_CFG/index.php");
require_once("../Functions/is_valid_registration.php");

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

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-Password'>
                <br>
                
                <label for='Birthday'>Birthday:</label><br>
                <input type='date' id='Birthday' name='Birthday' autocomplete='cc-Birthday'>
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
    $PWD = $_POST["Password"];
    $BDAY = $_POST["Birthday"];
    $BPLACE = $_POST["Birthplace"];

    $response = json_decode(is_valid_registration($conn, $FNAME, $MNAME, $LNAME, $PWD, $BDAY, $BPLACE), true);

        if(!$response["is_valid"]){
            $errors = $response["errors"];
            echo "<center>";

            for ($i=0; $i < count($errors); $i++) { 
                echo "$errors[$i]<br>";
            }

            echo "<center>";
        } else {
            $_SESSION["uuid"] = $response["uuid"];
            header("location: ../Dashboard/");
        }
}

?>