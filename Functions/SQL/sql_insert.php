<?php

function sql_insert($conn, $table_name, $sql_fields, $sql_values){
    
    array_push($sql_fields, "user_uuid");
    array_push($sql_values, $_SESSION["uuid"]);
    $sql_values = array_values($sql_values);

    $query = "
    INSERT INTO $table_name 
    (
        ".implode(", ", $sql_fields)."
    )
    VALUES
    (
        ".substr(str_repeat("?,", count($sql_values)), 0, -1)."
    )
    ";    


    $stmt = $conn->prepare($query) or die('prepare() failed: ' . htmlspecialchars($conn->error));
    $stmt_bind = $stmt->bind_param(str_repeat("s", count($sql_fields)), ...$sql_values);
    $stmt_exec = $stmt->execute();
    
    $response["is_valid"] = true;
    //die(json_encode($sql_values, true));
    return $response;
}

?>