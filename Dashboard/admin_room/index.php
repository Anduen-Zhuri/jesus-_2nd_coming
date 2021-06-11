<?php
session_start();

require_once("../../DB_CFG/index.php");

if(isset($_SESSION["uuid"])){

$stmt = $conn->prepare("SELECT is_admin FROM users WHERE uuid=?");
$stmt->bind_param("s", $_SESSION["uuid"]);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($is_admin);
$stmt->fetch();

if(!$is_admin){
    header("location: ../");  
}

$query = "SELECT uuid, first_name, middle_name, last_name FROM users WHERE is_admin=?";
$data = array();
$FNAME = false;
$MNAME = false;
$LNAME = false;
$EMAIL = false;
$should_be_admin = 0;
array_push($data, $should_be_admin);


if(isset($_GET['first_name']) && $_GET['first_name']){
    $query .= " AND first_name=?";
    array_push($data, $_GET['first_name']);
    $FNAME = $_GET['first_name'];
}

if(isset($_GET['middle_name']) && $_GET['middle_name']){
    $query .= " AND middle_name=?";
    array_push($data, $_GET['middle_name']);
    $MNAME = $_GET['middle_name'];
}

if(isset($_GET['last_name']) && $_GET['last_name']){
    $query .= " AND last_name=?";
    array_push($data, $_GET['last_name']);
    $LNAME = $_GET['last_name'];
}

if(isset($_GET['email']) && $_GET['email']){
    $query .= " AND email=?";
    array_push($data, $_GET['email']);
    $EMAIL = $_GET['email'];
}

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat("s", count($data)), ...$data);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($uuid, $FNAME, $MNAME, $LNAME);

$SEARCH_VIEW = "
    <a href='../'>&#8592; DASHBOARD</a>
    <h1>List of users:</h1>
    <form action='' method='POST'>
    <label for='first_name'>First name:</label><br>
    <input type='text' id='first_name' name='first_name' value='$FNAME'><br>

    <label for='middle_name'>Middle name:</label><br>
    <input type='text' id='middle_name' name='middle_name' value='$MNAME'><br>

    <label for='last_name'>Last name:</label><br>
    <input type='text' id='last_name' name='last_name' value='$LNAME'><br>

    <label for='email'>Email:</label><br>
    <input type='text' id='email' name='email' value='$EMAIL'><br>
    <input type='submit' name='SEARCH' value='SEARCH'>
    </form>
";

if(isset($_POST["SEARCH"])){
    header("Location: ./?first_name=$_POST[first_name]&middle_name=$_POST[middle_name]&last_name=$_POST[last_name]&email=$_POST[email]");
}

echo "
    <html>
        <head>
            <title>ADMIN ROOM</title>
            <meta name='viewport' content='width=device-width'>
        </head>
        <body>
";
if ($stmt->num_rows == 0) {
    if (!$FNAME && !$MNAME && !$LNAME && !$EMAIL) {
        echo "<h2>There are no users</h2>";
    } else {
        echo ($SEARCH_VIEW);
        echo "<h2>No users with these credentials</h2>";
    }
} else {
    echo ($SEARCH_VIEW);
    while($stmt->fetch()) {
        echo "
            <a href='./view_user/?uuid=$uuid'>$FNAME $MNAME $LNAME</a><br>
        ";
    }
}

echo "
        <body>
    </html>
";

} else {
    header("location: ../");
}

?>