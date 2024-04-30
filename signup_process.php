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

// SQL query to insert a new record into the Queue table
$query = "INSERT INTO Queue (FileID, UserName, Price) VALUES (:fileId, :userName, :price)";

// Prepare the SQL statement
$stmt = $pdo->prepare($query);

// Bind the form data to the SQL statement
$stmt->bindValue(':fileId', $fileId);
$stmt->bindValue(':userName', $userName);
$stmt->bindValue(':price', $price);

// Execute the SQL statement
$stmt->execute();

// Redirect to the user dashboard
header('Location: user.php');
?>