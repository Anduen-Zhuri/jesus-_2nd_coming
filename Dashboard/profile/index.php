<?php include('../../Layout/header.php'); ?>
<?php 
$pdo = new PDO('mysql:localhost;port=3306;dbname=employee_data', 'root', 'magno');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM personal_information');
$statement->execute();
//fetch as an associative array.
$profile = $statement->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($profile);
?>


<?php include('../../Layout/footer.php'); ?>