<?php

function is_valid_login($conn, $FNAME, $LNAME, $PWD){

    $errors = array();

    if(empty($FNAME)){
        array_push($errors, "* First name is empty");
    } else if (strlen($FNAME) <= 3){
        array_push($errors, "* First name is too short");
    } else if (strlen($FNAME) > 16){
        array_push($errors, "* First name is too long");
    }
    
    if(empty($LNAME)){
        array_push($errors, "* Last name is empty");
    } else if (strlen($LNAME) <= 3){
        array_push($errors, "* Last name is too short");
    } else if (strlen($LNAME) > 16){
        array_push($errors, "* Last name is too long");
    }

    if(!empty($errors)){
        $response["is_valid"] = false;
        $response["errors"] = $errors;

        return json_encode($response);
    }



$stmt = $conn->prepare("SELECT uuid, password FROM users WHERE first_name=? AND last_name=?");
$stmt->bind_param("ss", $FNAME, $LNAME);
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