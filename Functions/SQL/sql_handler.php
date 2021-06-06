<?php

require_once("sql_insert.php");
require_once("sql_update.php");

function onSubmit($conn, $query_type, $table_name, $sql_fields, $request, $validation_function){

    $errors = array();

    if(!isset($_SESSION["uuid"])){
        $response["is_valid"] = false;
        $response["errors"] = array("* You're not logged in");
        return $response;
    }

    if ($validation_function && !$validation_function($sql_fields, $request)["is_valid"]) {
        $response["is_valid"] = false;
        $response["errors"] = $validation_function($sql_fields, $request)["errors"];
        return $response;
    }
    
    switch($query_type){
        case "INSERT":
            return sql_insert($conn, $table_name, $sql_fields, $request);
            break;
        
        case "UPDATE":
            return sql_update($conn, $table_name, $sql_fields, $request);
            break;
    }

}
?>