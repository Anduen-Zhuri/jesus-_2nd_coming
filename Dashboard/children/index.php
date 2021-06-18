<?php
session_start();
include('../../Layout/header.php');
require_once("../../DB_CFG/index.php");
require_once("../../Functions/SQL/sql_handler.php");

if(!isset($_SESSION["uuid"])){
    header("Location: ../../");
}
?>


<?php
$fields = array(
    "Child name",
    "Child birthday"
);

$sql_field_names = array(
    'child_name',
    'child_birth_date'
);

$stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). ", children_id FROM children WHERE user_uuid=?");
$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $F_0, $F_1, $child_id);
$query_type = "INSERT";
if(isset($_POST["INSERT"])){
    for ($i=0; $i < count($fields); $i++) { 
        $object["$sql_field_names[$i]"] = $_POST["field_$i"];
    }

    $response = onSubmit($conn, $query_type, "children", $sql_field_names, $object, null);

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
    $stmt = $conn->prepare("SELECT children_id FROM children WHERE children_id=? AND user_uuid=?");
    $stmt->bind_param("ss", $id, $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM children WHERE children_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        header("Location: ./");
    }
}?>

<center>
<form action='' method='POST'>
<!-- -->
<div class="bg-light col-sm-4 m-4">
    <div class="form-group ">
    <label for="exampleInputEmail1">Child's Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name='field_0' placeholder="Child's Name">
    <small id="emailHelp" class="form-text text-muted">Surname, First Name, Middle Name</small>
    </div>

    <div class="form-group ">
    <label for="exampleInputEmail1">Child Birth Date</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name='field_1' placeholder="Birth Date">
    <small id="emailHelp" class="form-text text-muted">mm/dd/yyyy</small>
    </div>
  
  
<button type='submit' name='INSERT' class="btn btn-primary mt-1"> Insert </button><br>
</div>
</form>

</center>
<?php
if ($stmt->num_rows <= 0) {
    echo "<center><h3>You have no children this far</h3></center>";
} else {
    echo ("
    <div class='limiter'>
    <div class='mt-5'>
        <div class='wrap-table100'>
            <div class='table100 ver1 m-b-110'>
                <div class='table100-head'>
        <table>
            <thead>
                <tr class='row100 head'>
                    <th class='cell100 column1'>Child name</th>
                    <th class='cell100 column2'>Child birthday</th>
                    <th class='cell100 column3'>Remove</th>
                </tr>
            </thead>
            </table>
    </div>
       
    ");


    while ($stmt->fetch()) {
        echo ("
   <div class='table100-body js-pscroll'>
	<table>
        <tbody>
            <tr class='row100 body'>
                <td class='cell100 column1'>");

                    if (empty($F_0)){
                        echo "-";
                    } else {
                        echo $F_0;
                    }
        echo ("
                </td>
                <td class='cell100 column2'>");
                if (empty($F_1)){
                    echo "-";
                } else {
                    echo $F_1;
                }
                
                echo "
                </td>
                <td class='cell100 column3'>
                    
                        <form action='' method='POST'>
                            <button type='submit' name='REMOVE' value='$child_id' style='
                            background-color: transparent; border: 0px none; cursor: pointer;
                            '>
                                <img src='../../Img/remove.png' style='width: 2rem; height: 2rem;'>
                            </button>
                        </form>
                    
                </td>
            </tr>
            
        ";
    }
    echo " </tbody>
    </table></div> </div> </div> </div> </div>";
}
?>


<?php include('../../Layout/footer.php');
      include("../../styles/table_style/table_include.php");
    ?>