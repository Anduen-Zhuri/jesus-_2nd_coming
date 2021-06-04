<?php

session_start();

require_once("./DB_CFG/index.php");
require_once("./Functions/is_valid_login.php");

if(isset($_SESSION["uuid"])){
    header("location: ./Dashboard/");
} else {
include('login.php');
}

if(isset($_POST["LOGIN"])){
    $EMAIL = $_POST["Email"];
    $PWD = $_POST["Password"];

    $response = json_decode(is_valid_login($conn, $EMAIL, md5($PWD)), true);

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
