<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$form_data = $_POST;
include 'db_connect.php';


/*$Queue = $pdo->query("
    SELECT Queue.QueueID, User.UserName, Song.SongName, Artist.ArtistName, Song.KaraokeFileID
    FROM Queue
    JOIN User ON Queue.UserID = User.UserID
    JOIN Song ON Queue.SongID = Song.SongID
    JOIN Artist ON Song.ArtistID = Artist.ArtistID
")->fetchAll();*/






$songs = $pdo->query("
    SELECT * FROM Song
    ")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" href="icon.png" type="image/x-icon">
</head>

<body>
    <div class="admin-body">
        <h1 style="font-size: 2em;">Welcome to Karaoke Event Application</h1> 
        <p style="font-size: 1.5em;">Please select your role:</p>

        <a href="user.php" class="button">User</a>
        <a href="dj.php" class="button">DJ</a>
        <a href="admin.php" class="button">Admin</a>
        
    </div>
</body>

</html>
