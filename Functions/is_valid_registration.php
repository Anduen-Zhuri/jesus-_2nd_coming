<?php

function is_valid_registration($conn, $date_format, $FNAME, $MNAME, $LNAME, $EMAIL, $PWD, $BDAY, $BPLACE){
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
    
    if(empty($EMAIL)){
        array_push($errors, "* Email is empty");
    }
    
    if(empty($PWD)){
        array_push($errors, "* Password is empty");
    } else if (strlen($PWD) <= 6){
        array_push($errors, "* Password is too short");
    }

    if (empty($BDAY)) {
        array_push($errors, "* You need to set a birth date");
    } else if(!preg_match($date_format, $BDAY)){
        array_push($errors, "* Wrong date format on Birthday field(must be mm-dd-yyyy)");
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
    $response["user_exists"] = true;
}

$response["is_valid"] = true;
return json_encode($response);

}

?>