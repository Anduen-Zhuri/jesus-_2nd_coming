<?php

session_start();

require_once("./DB_CFG/index.php");
require_once("./Functions/is_valid_login.php");

if(isset($_SESSION["uuid"])){
    header("location: ./Dashboard/");
} else {

echo "
<html>
    <head>
        <title>Index</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <center>
            <form method='POST' action=''>
                <label for='Firstname'>First name:</label><br>
                <input type='text' id='Firstname' name='Firstname' autocomplete='cc-firstname'>
                <br>
                
                <label for='Lastname'>Last name:</label><br>
                <input type='text' id='Lastname' name='Lastname' autocomplete='cc-firstname'>
                <br>

                <label for='Password'>Password:</label><br>
                <input type='password' id='Password' name='Password' autocomplete='cc-password'>
                <br><br>
                <input type='submit' value='LOGIN' name='LOGIN'>
            </form>
            <a href='./Register/'>REGISTER</a>
        </center>
    </body>
</html>
";
}

if(isset($_POST["LOGIN"])){
    $FNAME = $_POST["Firstname"];
    $LNAME = $_POST["Lastname"];
    $PWD = $_POST["Password"];

    $response = json_decode(is_valid_login($conn, $FNAME, $LNAME, md5($PWD)), true);

     if(!$response["is_valid"]){
        $errors = $response["errors"];

         echo "<center>";

         for ($i=0; $i < count($errors); $i++) { 
             echo "$errors[$i]<br>";
         }

         echo "<center>";
     } else {
        $_SESSION["uuid"] = $response["uuid"];
        header("location: ./Dashboard/");
    }
}
?>
