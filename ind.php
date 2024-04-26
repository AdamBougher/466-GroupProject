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
    SELECT * FROM KaraokeFiles
    JOIN Song ON KaraokeFiles.SongID = Song.SongID
    JOIN Contributor ON Song.ArtistName = Contributor.ArtistName
    ")->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container">
        <h1 style="font-size: 2em;">Welcome to Karaoke Event Application</h1> 
        <p style="font-size: 1.5em;">Please select your role:</p>

        <a href="user.php" class="button">User</a>
        <a href="dj.php" class="button">DJ</a>
        <a href="admin.php" class="button">Admin</a>
        
        <h1>UpNext</h1>
            <table id="songTable">
                <tr>
                    <th>Name</th>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Version</th>
                </tr>

                
            </table>



        <h1>Playlist</h1>
        <table id="songTable">
                <tr>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Version</th>
                </tr>
                <?php if (!empty($songs)) : ?>
                    <?php foreach ($songs as $song) : ?>
                        <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['Title']; ?>', this)">
                            <td><?php echo $song['Title']; ?></td>
                            <td><?php echo $song['ArtistName']; ?></td>
                            <td><?php echo $song['Version']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
        </table>

    </div>
</body>

</html>
