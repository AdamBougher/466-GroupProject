<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

$songs = $pdo->query("
SELECT * FROM (
SELECT * FROM Queue 
UNION 
SELECT * FROM PriorityQueue
) q
JOIN KaraokeFiles k ON q.FileID = k.FileID
JOIN Song s ON k.SongID = s.SongID
ORDER BY q.QueueID ASC
")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Dashboard - Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="admin-body">
        <h1 class="header"> User Dashboard</h1>
        <p class="form-label">Welcome to the User Dashboard! Here, you can search for songs and sign up to sing.</p>

        <br>
        <h2>Search for Songs</h2>
        <p class="form-label">Enter the artist name, song title, or contributor in the search box below:</p>
        <form action="search.php" method="post">
            <input type="text" name="search" placeholder="Search for songs...">
            <input type="submit" value="Search" class="search-button">
        </form>

        <h1>Current Queue</h1>
        <div style="overflow-x: auto;">
            <table id="Song List">
                    <tr>
                        <th>Singer</th>
                        <th>Song</th>
                        <th>Length</th>
                    </tr>
                    <?php if (!empty($songs)) : ?>
                        <?php foreach ($songs as $song) : ?>
                            <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['Title']; ?>', this)">
                                <td><?php echo $song['Username']?></td>
                                <td><?php echo $song['Title'] . " By " . $song['ArtistName'] . " - " . $song['Version'];;?></td>
                                <td><?php echo $song['SongLength'];?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </table>
        </div>
        <br>
        <h2>Sign Up to Sing</h2>
        <p class="form-label">Found a song you want to sing? Great! Select the song and choose your queue:</p>
        <form action="signup.php" method="post">
            <input type="submit" value="Go to Sign Up" class="button">
        </form>
        <a href="ind.php" class="back-button">Back</a>
    </div>
</body>

</html>
