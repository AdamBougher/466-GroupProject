<?php
// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

// Get the form data
$userId = $_POST['user'];
$songId = $_POST['selectedSong']; // Corrected here
$price = isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : NULL;

//  SQL query to insert a new record into the Queue table
$query = "INSERT INTO Queue (SongID, UserID, Price) VALUES (:songId, :userId, :price)";

// Prepare the SQL statement
$stmt = $pdo->prepare($query);

// Bind the form data to the SQL statement
$stmt->bindValue(':songId', $songId);
$stmt->bindValue(':userId', $userId);
$stmt->bindValue(':price', $price);

// Execute the SQL statement
$stmt->execute();

// Redirect the user back to the dashboard with a success message
header("Location: user.php?signup=success");
?>
