<?php
// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// Get the form data
$userName = $_POST['userName'];
$fileId = $_POST['selectedSong'];
$price = isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : NULL;

if($price == null || $price <= 0){
    $table = 'Queue';
} else{
    $table = 'PriorityQueue';
}

$stmt = $pdo->prepare("INSERT INTO $table (FileID, UserName, Price) VALUES (:fileId, :userName, :price)");

// Bind the values
$stmt->bindValue(':fileId', $fileId);
$stmt->bindValue(':userName', $userName);
$stmt->bindValue(':price', $price);

// Execute
$stmt->execute();

// Redirect to the user dashboard
header('Location: user.php');
?>