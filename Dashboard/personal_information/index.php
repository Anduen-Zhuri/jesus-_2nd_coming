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
    "First name",
    "Middle name",
    "Last name",
    "Name extension",
    "Citizenship",
    "Civil status",
    "Gender",
    "Birthday",
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
    "Date recorded",
    "Residing HBL",
    "Residing Street",
    "Residing Subvil",
    "Residing Barangay",
    "Residing City Municipality",
    "Residing Province",
    "Residence Zipcode",
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
    "Membership name",
    "Non-Academic distinction",
    "Hobby"
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
    'date_recorded',
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
    $F_39, $F_40, $F_41, $F_42, $F_43, $F_44, $F_45, $F_46, $F_47, $F_48, $F_49, $F_50, $F_51, $F_52, $F_53, $F_54, $F_55, $F_56
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
<?php
for ($i=0; $i < count($fields); $i++) { 
    eval('$value = $F_'.$i.';');
    echo ("
        <label for='field_$i'>$fields[$i]:</label><br>
        <input type='text' id='field_$i' value='$value' name='field_$i'><br>
    ");
} 
?>

<br>
<input type="file" name="avatar">
<br>
<br>
<input type='submit' name='SUBMIT' value='SUBMIT'>
</form>

<!-- end of form view -->
<?php include('./persona_information_view.php');?>
</center>

<?php include('../../Layout/footer.php');


?>
