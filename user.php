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


$Queue = $pdo->query("
SELECT Queue.QueueID, User.UserName, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles, Song.KaraokeFileID
FROM Queue
JOIN User ON Queue.UserID = User.UserID
JOIN Song ON Queue.SongID = Song.SongID
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
LEFT JOIN SongContributor ON Song.SongID = SongContributor.SongID
LEFT JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
LEFT JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Queue.QueueID;
")->fetchAll();



$songs = $pdo->query("SELECT * FROM Song")->fetchAll();

?>



<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard - Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <p>Welcome to the User Dashboard! Here, you can search for songs, sign up to sing, and view the queue of upcoming performances.</p>

        <h2>Search for Songs</h2>
        <p>Enter the artist name, song title, or contributor in the search box below:</p>
        <form action="search.php" method="post">
            <input type="text" name="search" placeholder="Search for songs...">
            <input type="submit" value="Search" class="search-button">
        </form>

        <h2>Sign Up to Sing</h2>
        <p>Found a song you want to sing? Great! Select the song and choose your queue:</p>
        <form action="signup.php" method="post">
            <input type="submit" value="Go to Sign Up" class="button">
        </form>

        <h2>View Queue</h2>
        <p>Check out the queue to see the list of upcoming performances:</p>
        <table>
            <tr>
                <th>User</th>
                <th>Song</th>
                <th>Artist</th>
                <th>Karaoke File ID</th>
                <th>Queue
            </tr>
            <?php foreach ($Queue as $performance) : ?>
                <tr>
                    <td><?php echo $performance['UserName']; ?></td>
                    <td><?php echo $performance['SongName']; ?></td>
                    <td><?php echo $performance['ArtistName']; ?></td>
                    <td><?php echo $performance['KaraokeFileID']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div>

        <a href="ind.php" class="back-button">Back</a>
    </div>

</body>

</html>
