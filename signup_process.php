<?php
// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// Get the form data
$userName = $_POST['userName'];
$songId = $_POST['selectedSong'];
$price = isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : NULL;

// Get the user ID from the User table
$stmt = $pdo->prepare("SELECT UserID FROM User WHERE UserName = :userName");
$stmt->bindValue(':userName', $userName);
$stmt->execute();
$user = $stmt->fetch();

$table = 'Queue';

$stmt = $pdo->prepare("INSERT INTO $table (SongID, UserID, UserName, Price) VALUES (:songId, :userId, :userName, :price)");

// Bind the values
$stmt->bindValue(':songId', $songId);
$stmt->bindValue(':userId', $user['UserID']);
$stmt->bindValue(':userName', $userName);
$stmt->bindValue(':price', $price);

// Execute
$stmt->execute();

// Redirect to the user dashboard
header('Location: user.php');
?>