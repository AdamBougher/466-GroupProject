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

// Check if the song exists in the KaraokeFiles table
$songQuery = "SELECT FileID FROM KaraokeFiles WHERE SongID = :songId";
$songStmt = $pdo->prepare($songQuery);
$songStmt->bindValue(':songId', $songId);
$songStmt->execute();
$song = $songStmt->fetch(PDO::FETCH_ASSOC);

if (!$song) {
    // If the song does not exist, return an error
    die("The selected song does not exist.");
} else {
    $fileId = $song['FileID'];
}

// SQL query to insert a new record into the Queue table
$query = "INSERT INTO Queue (FileID, Username, Price) VALUES (:fileId, :userName, :price)";

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
