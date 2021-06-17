<!--
The codes below are product of abomination, Please do not ask me why i didn't refactor it into MVC.
Refactoring it would probably take more time compared to redoing it from scratch.
Whoever you are, goodluck on making future revisions my friend.
    ~Ed                                 ||
    -->

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
    "First name",
    "Middle name",
    "Last name",
    "Name extension",
    "Citizenship",
    "Civil status",
    "Gender",
    "Birth Date (mm/dd/yyyy)",
    "Place of birth",
    "Height",
    "Weight",
    "Blood type",
    "GSIS ID number",
    "Pagibig ID number",
    "PhilHealth number",
    "SSS number",
    "TIN number",
    "Agency employee number",
    "Telephone number",
    "Mobile number",
    "Email",
   
    "House/Block/Lot No.",
    "Street",
    "Subdivision/Village",
    "Barangay",
    "City/Municipality",
    "Province",
    "Zipcode",
    "Permanent HBL",
    "Permanent Street",
    "Permanent Subvil",
    "Permanent Barangay",
    "Permanent City Municipality",
    "Permanent Province",
    "Permanent Zipcode",
    "Spouse First name",
    "Spouse Middle name",
    "Spouse Last name",
    "Spouse Name extension",
    "Spouse occupation",
    "Spouse Employer business",
    "Spouse Business address",
    "Father's First name",
    "Father's Middle name",
    "Father's Last name",
    "Father's name extension",
    "Mother's First name",
    "Mother's Middle name",
    "Mother's Last name",
    "Mother's Maiden name",
    "GOV-issued ID",
    "ID LIC pass",
    "Issued date",
    "Membership name: separate with comma (,)",
    "Non-Academic distinction: separate with comma (,)",
    "Hobbies: separate with comma (,)"
);

$sql_field_names = array(
    'first_name',
    'middle_name',
    'surname',
    'name_extension',
    'citizenship',
    'civil_status',
    'gender',
    'birth_date',
    'place_of_birth',
    'height',
    'weight',
    'blood_type',
    'gsis_id_no',
    'pagibig_id_no',
    'philhealth_no',
    'sss_no',
    'tin_no',
    'agency_employee_no',
    'tel_no',
    'mobile_no',
    'email',
    
    'res_hbl',
    'res_street',
    'res_subvil',
    'res_barangay',
    'res_city_municipality',
    'res_province',
    'res_zipcode',
    'perm_hbl',
    'perm_street',
    'perm_subvil',
    'perm_barangay',
    'perm_city_municipality',
    'perm_province',
    'perm_zipcode',
    'spouse_first_name',
    'spouse_middle_name',
    'spouse_surname',
    'spouse_name_extension',
    'spouse_occupation',
    'spouse_employer_business',
    'spouse_business_address',
    'fathers_first_name',
    'fathers_middle_name',
    'fathers_surname',
    'fathers_name_extension',
    'mothers_first_name',
    'mothers_middle_name',
    'mothers_sur_name',
    'mothers_maiden_name',
    'gov_issued_id',
    'id_lic_pass',
    'issued_date',
    'membership_name',
    'non_acad_distinction',
    'hobby'
);

$stmt = $conn->prepare("SELECT " .implode(", ", $sql_field_names). " FROM personal_information WHERE user_uuid=?");

$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
    $F_0, $F_1, $F_2, $F_3, $F_4, $F_5, $F_6, $F_7, $F_8, $F_9, $F_10, $F_11, $F_12, $F_13, $F_14, $F_15, $F_16, $F_17, $F_18, $F_19,
    $F_20, $F_21, $F_22, $F_23, $F_24, $F_25, $F_26, $F_27, $F_28, $F_29, $F_30, $F_31, $F_32, $F_33, $F_34, $F_35, $F_36, $F_37, $F_38,
    $F_39, $F_40, $F_41, $F_42, $F_43, $F_44, $F_45, $F_46, $F_47, $F_48, $F_49, $F_50, $F_51, $F_52, $F_53, $F_54, $F_55
); //Bruhhhh wtf! ur varaibles sux
$stmt->fetch();

if ($stmt->num_rows > 0) {
    $query_type = "UPDATE";
} else {
    $query_type = "INSERT";
}

if(isset($_POST["SUBMIT"])){
    for ($i=0; $i < count($fields); $i++) { 
        $object["$sql_field_names[$i]"] = $_POST["field_$i"];
    }
    $response = onSubmit($conn, $query_type, "personal_information", $sql_field_names, $object, null);

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

if(isset($_FILES['avatar'])){
    $errors = array();
    $file_name = $F_0."_".$F_1."_".$F_2.".png";
    $file_size = $_FILES['avatar']['size'];
    $file_tmp = $_FILES['avatar']['tmp_name'];
    $file_type = $_FILES['avatar']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['avatar']['name'])));
    $extensions = array("jpeg","jpg","png");
    $errors = array();
    
    if(in_array($file_ext,$extensions)=== false){
       array_push($errors, "extension not allowed, please choose a JPEG or PNG file.");
    }
    
    if($file_size > 5000000){
        array_push($errors, 'File size must be excately 2 MB');
    }
    
    if(empty($errors)==true){
       move_uploaded_file($file_tmp,"../../Img/Users/".$file_name);
       //echo "Success";
    }else{
       //print_r($errors);
    }
 }

?>
<!-- Start of Form View -->
<form action='' method='POST' enctype="multipart/form-data">
<br>
<center>
<?php
  $fname = $F_0;
  $mname = $F_1;
  $lname = $F_2;
  $url = "../../Img/Users/" . $fname . "_" . $mname . "_" . $lname . "." . "png";

  echo("
<img src='$url' class='img-thumbnail'>
<br>
")
?>

<input type="file" name="avatar">
</center>

            <br>
            
    <div class="d-flex flex-row container">

<!--General Information -->

        <div class='card' style='width: 14rem; height: 56rem; margin: 3px; background: #FFF'>
        <div class='card-body'>
            <h5 class='card-title'>General Information</h5>
                <?php
                        for ($i=0; $i < 12; $i++) { 
                            eval('$value = $F_'.$i.';');
                            echo ("
                                <div class='d-flex flex-column bd-highlight mb-1'>
                                    <div class'flex-row bd-highlight mb-1'>
                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm '>
                                    </div>
                                </div>
                            ");
                        } 
                ?>
                </div>
            </div>
   <!--Contain two -->  
   <div class="flex-column">
            <!--start ID numbers -->
            <div class='card' style='width: 14rem; height: 30rem; margin: 3px;'>
                        <div class='card-body'>
                            <h5 class='card-title'>ID's</h5>
                                <?php
                                        for ($i=12; $i < 18; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm '>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>
                                </div>
                            </div>
                <!--start Contact Info -->
                <div class='card' style='width: 14rem; height: 25rem; margin: 3px; margin-top: 13px;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Contact Information</h5>
                                <?php
                                        for ($i=18; $i < 21; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control '>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>
                                </div>
                            </div>
        </div>
        
        <!--start Current Address -->
        <div class="flex-row">
        
       
        <div class='card' style='width: 14rem; height: 35rem; margin: 3px;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Current Address</h5>
                                <?php
                                        for ($i=21; $i < 28; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>
                                </div>
                            </div> 
                            <div class='card' style='width: 14rem; height: 20rem; margin: 3px; padding: 1rem; margin-top: 14px;'>   
                            <h5 class='card-title'>Father</h5>
                                <?php
                                        for ($i=42; $i < 46; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>   
                            </div>                
        </div>



        <!--start Permnent Address -->
        <div class="flex-row">
                        <div class='card' style='width: 14rem; height: 35rem; margin: 3px; '>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Permanent Address</h5>
                                                <?php
                                                        for ($i=28; $i < 35; $i++) { 
                                                            eval('$value = $F_'.$i.';');
                                                            echo ("
                                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                                    <div class'flex-row bd-highlight mb-1'>
                                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                                    </div>
                                                                </div>
                                                            ");
                                                        } 
                                                ?>
                                        </div>
                        </div>  
                        <div class='card' style='width: 14rem; height: 20rem; margin: 3px; margin-top:13px;'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Mother</h5>
                                                <?php
                                                        for ($i=46; $i < 50; $i++) { 
                                                            eval('$value = $F_'.$i.';');
                                                            echo ("
                                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                                    <div class'flex-row bd-highlight mb-1'>
                                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                                    </div>
                                                                </div>
                                                            ");
                                                        } 
                                                ?>
                                        </div>
                        </div>  

         </div>

                            
        <!--start Spouse -->
        <div class ="flex-row">
        
        <div class='card' style='width: 14rem; height: 37rem; margin: 3px;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Spouse</h5>
                          
                                <?php
                                        for ($i=36; $i < 42; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>

                           
            </div>
        </div> 

        <div class='card' style='width: 14rem; height: 18rem; margin: 3px; margin-top:13;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Misc</h5>
                          
                                <?php
                                        for ($i=50; $i < 53; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <input type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>

                           
            </div>
        </div> 

    </div>                                 
</div>
<center>
<div class='card' style='width: 40rem; margin: 3px; margin-top:13;'>
<div class='card-body'>
                            <h5 class='card-title'>Misc</h5>
                          
                                <?php
                                        for ($i=53; $i < 56; $i++) { 
                                            eval('$value = $F_'.$i.';');
                                            echo ("
                                                <div class='d-flex flex-column bd-highlight mb-1'>
                                                    <div class'flex-row bd-highlight mb-1'>
                                                    <label for='field_$i' class='mb-1 '>$fields[$i]:</label>
                                                    <textarea type='text' id='field_$i' value='$value' name='field_$i' class='mb-1 form-control form-control-sm'></textarea>
                                                    </div>
                                                </div>
                                            ");
                                        } 
                                ?>
</div></div>
<input type='submit' name='SUBMIT' value='SUBMIT'>
</center>

</form>
<!-- end of form view -->

<?php include('../../Layout/footer.php');?>
