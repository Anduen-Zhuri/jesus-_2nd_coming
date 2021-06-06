<?php
session_start();
include('../../Layout/header.php');
require_once("../../DB_CFG/index.php");
require_once("../../Functions/SQL/sql_handler.php");

if(!isset($_SESSION["uuid"])){
    header("Location: ../../");
}
?>

<center>
<?php


$fields = array(
    "Question",
    "Yes/No",
    "Details"
);

$sql_field_names = array(
    "question",
    "yes_no",
    "details"
);

$stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). ", question_ID FROM questions WHERE user_uuid=?");

$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $F_0, $F_1, $F_2, $question_ID);

$query_type = "INSERT";

if(isset($_POST["INSERT"])){
    for ($i=0; $i < count($fields); $i++) { 
        $object["$sql_field_names[$i]"] = $_POST["field_$i"];
    }

    $response = onSubmit($conn, $query_type, "questions", $sql_field_names, $object, null);

    if($response["is_valid"]){
        header("Location: ./");
    } else {
        if ($response["errors"]) {
            for ($i=0; $i <= count($response["errors"]); $i++) { 
                echo "$response[errors][$i] <br>";
            }
        } else {
            echo "Unknown error!<br>";
        }
    }
}

if(isset($_POST["REMOVE"])){
    $id = $_POST["REMOVE"];

    $stmt = $conn->prepare("SELECT question_ID FROM questions WHERE question_ID=? AND user_uuid=?");

    $stmt->bind_param("ss", $id, $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM questions WHERE question_ID=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        header("Location: ./");
    }
}

?>
<style>
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even) td {
        border-top-width: 0px;
    }
</style>

<form action='' method='POST'>

<table style='width: fit-content'>
    <tr>
        <th><center>Question</center></th>
        <th><center>Yes/No Question?</center></th>
        <th><center>Details</center></th>
    </tr>
    <tr>
        <td><center><textarea name='field_0' rows='2' cols='10'></textarea></center></td>
        <td><center><textarea name='field_1' rows='2' cols='10'></textarea></center></td>        
        <td><center><textarea name='field_2' rows='2' cols='10'></textarea></center></td>
    </tr>
</table>
<input type='submit' name='INSERT' value='INSERT'><br>
</form>

<?php

if ($stmt->num_rows <= 0) {
    echo "<h3>You havent asked anything</h3>";
} else {
    echo "
        <table style='width: fit-content'>
            <tr>
                <th><center>Question</center></th>
                <th><center>Yes/No</center></th>
                <th><center>Details</center></th>
                <th><center>Remove</center></th>
            </tr>
    ";

    while ($stmt->fetch()) {
        echo "
            <tr>
                <td><center>";

                    if (empty($F_0)){
                        echo "-";
                    } else {
                        echo $F_0;
                    }
                    
                    echo "
                </center></td>
                <td><center>";

                if (empty($F_1)){
                    echo "-";
                } else {
                    echo $F_1;
                }

                    echo "
                </center></td>
                <td><center>";

                if (empty($F_2)){
                    echo "-";
                } else {
                    echo $F_2;
                }
                
                echo "
                </center></td>
                <td style='align-items: center;'>
                    <center>
                        <form action='' method='POST'>
                            <button type='submit' name='REMOVE' value='$question_ID' style='
                                background-color: transparent; border: 0px none; cursor: pointer;
                            '>
                                <img src='../../Img/remove.png' style='width: 2rem; height: 2rem;'>
                            </button>
                        </form>
                    </center>
                </td>
            </tr>
        ";
    }
    echo "</table>";
}
?>

</center>

<?php include('../../Layout/footer.php');?>