<?php

function sql_update($conn, $table_name, $sql_fields, $sql_values){

    $sql_fields = array_values($sql_fields);

    $sql_fields = array_map(function($value){
        return ("$value = ?"); 
    }, $sql_fields);

    $query = "UPDATE $table_name SET ".implode(", ", $sql_fields)." WHERE user_uuid = ?";
    
    $sql_values["user_uuid"] = $_SESSION["uuid"];
    $sql_values = array_values($sql_values);

    $stmt = $conn->prepare($query) or die('prepare() failed: ' . htmlspecialchars($mysqli->error));
    $stmt_bind = $stmt->bind_param(str_repeat("s", count($sql_fields) + 1), ...$sql_values);
    $stmt_exec = $stmt->execute();
    
    $response["is_valid"] = true;

    return $response;
}

?>