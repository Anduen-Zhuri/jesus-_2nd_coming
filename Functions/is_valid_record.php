<?php

function is_valid_record(
    $conn,
    $date_format,
    $date_from,
    $date_to,
    $designation,
    $status,
    $monthly_salary,
    $assignment_place,
    $LAWOP,
    $separation_date,
    $separation_cause
){
    $errors = array();

    if (empty($date_from)) {
        array_push($errors, "* You need to set a starting date");
    } else if(!preg_match($date_format, $date_from)){
        array_push($errors, "* Wrong date format on From field(must be mm/dd/yyyy)");
    }
    
    if (empty($date_to)) {
        array_push($errors, "* You need to set an ending date");
    } else if(!preg_match($date_format, $date_to)){
        array_push($errors, "* Wrong date format on To field(must be mm/dd/yyyy)");
    }
    
    if (empty($designation)) {
        array_push($errors, "* You need to set a designation");
    }

    if (empty($status)) {
        array_push($errors, "* You need to set a status");
    }
    
    if (empty($monthly_salary)) {
        array_push($errors, "* You need to set a monthly salary");
    }
    
    if (empty($assignment_place)) {
        array_push($errors, "* You need to set an assignment place");
    }
    
    if (empty($LAWOP)) {
        array_push($errors, "* LAWOP cant be empty");
    }
    
    if (!empty($separation_date) && !preg_match($date_format, $separation_date)) {
        array_push($errors, "* Wrong date format on Separation date field(must be mm/dd/yyyy)");
    }

    if (!empty($errors)) {
        $response["is_valid"] = false;
        $response["errors"] = $errors;
    } else {
        $response["is_valid"] = true;
    }

    return json_encode($response);
}
?>