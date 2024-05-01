<?php
// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

/*** !Update to match create.sql ***/

// Get the form data
$userName = $_POST['userName'];
$songId = $_POST['selectedSong'];
$price = isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : NULL;

// Look up the UserID based on the UserName
$userQuery = "SELECT UserID FROM User WHERE UserName = :userName";
$userStmt = $pdo->prepare($userQuery);
$userStmt->bindValue(':userName', $userName);
$userStmt->execute();
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // If the user does not exist, insert a new record into the User table
    $insertUserQuery = "INSERT INTO User (UserName) VALUES (:userName)";
    $insertUserStmt = $pdo->prepare($insertUserQuery);
    $insertUserStmt->bindValue(':userName', $userName);
    $insertUserStmt->execute();

    // Get the ID of the newly inserted user
    $userId = $pdo->lastInsertId();
} else {
    $userId = $user['UserID'];
}

// SQL query to insert a new record into the Queue table
$query = "INSERT INTO Queue (SongID, UserID, UserName, Price) VALUES (:songId, :userID, :userName, :price)";

// Prepare the SQL statement
$stmt = $pdo->prepare($query);

// Bind the form data to the SQL statement
$stmt->bindValue(':songId', $songId);
$stmt->bindValue(':userID', $userId);
$stmt->bindValue(':userName', $userName);
$stmt->bindValue(':price', $price);

// Execute the SQL statement
$stmt->execute();


// Redirect to the user dashboard
header('Location: user.php');
?>
