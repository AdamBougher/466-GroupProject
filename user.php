<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connect.php';

$songs = $pdo->query("
SELECT * FROM KaraokeFiles
JOIN Song ON KaraokeFiles.SongID = Song.SongID
JOIN Contributor ON Song.ArtistName = Contributor.ArtistName
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

        <h1>Playlist</h1>
        <table id="Song List">
                <tr>
                    <th>Song</th>
                    <th>Artist</th>
                </tr>
                <?php if (!empty($songs)) : ?>
                    <?php foreach ($songs as $song) : ?>
                        <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['Title']; ?>', this)">
                            <td><?php echo $song['Title'] . ' - ' . $song['Version']; ?></td>
                            <td><?php echo $song['ArtistName']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
        </table>
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
