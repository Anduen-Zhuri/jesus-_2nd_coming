<?php

function is_valid_login($conn, $EMAIL, $PWD){

    $errors = array();

    if(empty($EMAIL)){
        array_push($errors, "* Email is empty");
    }

    if(!empty($errors)){
        $response["is_valid"] = false;
        $response["errors"] = $errors;

        return json_encode($response);
    }



$stmt = $conn->prepare("SELECT uuid, password FROM users WHERE email=?");
$stmt->bind_param("s", $EMAIL);
$stmt->execute();
$stmt->store_result();  

$stmt->bind_result($uuid, $correct_password);
$stmt->fetch();
if ($stmt->num_rows > 0) {
    if ($PWD == $correct_password) {
        $response["is_valid"] = true;
        $response["uuid"] = $uuid;
    } else {
        $response["is_valid"] = false;
        array_push($errors, "* Wrong password");
    }
} else {
    $response["is_valid"] = false;
    array_push($errors, "* This user is not registered");
}

if (!empty($errors)) {
    $response["errors"] = $errors;
}

    $stmt->free_result();
    $stmt->close();
    $conn->close();
    return json_encode($response);

}

?>