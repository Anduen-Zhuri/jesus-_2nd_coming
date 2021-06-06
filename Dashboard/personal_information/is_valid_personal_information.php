<?php
session_start();
include('../../Layout/header.php');
require_once("../../DB_CFG/index.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$errors = array(); 

if(!isset($_SESSION["uuid"]) || !isset($_GET["request"]) || !$_GET["request"]){
    array_push("* Not logged in", $errors);
} else {

$stmt = $conn->prepare("SELECT user_uuid FROM personal_information WHERE user_uuid=?");
$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();

$request = json_decode($_GET["request"], true);

if ($stmt->num_rows > 0) {
    $sql_field_names = array_keys($request);
    
    $sql_field_names = array_map(function($value){
        return ("$value = ?"); 
    }, $sql_field_names);

    $query = "UPDATE personal_information SET ".implode(", ", $sql_field_names)." WHERE user_uuid = ?";
    $request["user_uuid"] = $_SESSION["uuid"];

} else {
    $request["user_uuid"] = $_SESSION["uuid"];

    $query = "
    INSERT INTO personal_information 
    (
        ".implode(", ", array_keys($request))."
    )
    VALUES
    (
        ".substr(str_repeat("?,", count($request)), 0, -1)."
    )
    ";
}

$array_values = array_values($request);
$stmt = $conn->prepare($query) or die('{"is_valid": false, "errors": ["Database error"]}');
$stmt_bind = $stmt->bind_param(str_repeat("s", count($request)), ...$array_values);
$stmt_exec = $stmt->execute();

if ($stmt_exec === false || $stmt_bind === false || $stmt === false) {
    array_push("* Database error, contact the administrator", $errors);
}
  
}

if(empty($errors)){
    $response["is_valid"] = true;
} else {
    $response["is_valid"] = false;
    $response["errors"] = $errors;
}

echo(json_encode($response));

?>