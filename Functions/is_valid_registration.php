<?php

require_once("../Functions/generate_uuid.php");

function is_valid_registration($conn, $FNAME, $MNAME, $LNAME, $PWD, $BDAY, $BPLACE){
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
    
    if(empty($PWD)){
        array_push($errors, "* Password is empty");
    } else if (strlen($LNAME) <= 6){
        array_push($errors, "* Password is too short");
    }

    if(empty($BDAY)){
        array_push($errors, "* You need to set a birth date");
    }

    if(empty($BPLACE)){
        array_push($errors, "* Birth place cant be empty");
    }

    if(!empty($errors)){
        $response["is_valid"] = false;
        $response["errors"] = $errors;

        return json_encode($response);
    }

//check if FNAME exists
$stmt = $conn->prepare("SELECT id FROM users WHERE first_name=? AND last_name=?");
$stmt->bind_param("ss", $FNAME, $LNAME);
$stmt->execute();
$stmt->store_result();  

if ($stmt->num_rows > 0) {
    $response["is_valid"] = false;
    array_push($errors, "* This user is already taken");
    $response["errors"] = $errors;

    return json_encode($response);
}

$UUID = generate_uuid();
$PWD = md5($PWD);

$stmt = $conn->prepare("INSERT INTO users (uuid, first_name, middle_name, last_name, birth_day, birth_place, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $UUID, $FNAME, $MNAME, $LNAME, $BDAY, $BPLACE, $PWD);
$stmt->execute();
$stmt->free_result();
$stmt->close();
$conn->close();



$response["is_valid"] = true;
$response["uuid"] = $UUID;
return json_encode($response);

}

?>