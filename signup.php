<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$songs = $pdo->query("
SELECT s.SongID, s.Title AS SongName, s.ArtistName, s.Genre, kf.Version AS VersionName
FROM Song s
JOIN KaraokeFiles kf ON s.SongID = kf.SongID
")->fetchAll();



$queues = $pdo->query("SELECT * FROM Queue")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <title>Sign Up to Sing - Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js"></script>
</head>

<body>
    
    <div class="admin-body">
        <h1 class="header">Sign Up to Sing</h1>

        <form action="signup_process.php" method="post" onsubmit="return validateForm()">
            <br>
            <label for="userName" class="form-label">Enter a User Name:</label>
            <br>
            <input type="text" name="userName" id="userName" class="form-input" placeholder="Enter a user name..." required="">
    
        <br>
        <br>
        <input type="hidden" id="selectedSong" name="selectedSong">

        <br>
        <div style="overflow-x: auto; overflow-y: auto; max-height: 500px;">
            <table id="songTable">
                <thead>
                <tr>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Genre</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($songs)) : ?>
                    <?php foreach ($songs as $song) : ?>
                        <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['SongName']; ?>', this)">
                            <td><?php echo $song['SongName'] . " - " . $song['VersionName']; ?></td>
                            <td><?php echo $song['ArtistName']; ?></td>
                            <td><?php echo $song['Genre']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <br>
        <br>
        <label for="price" class="form-label">Price:</label>
        <br>
        <input type="number" name="price" id="price" class="form-input" placeholder="Empty for normal queue">

        <br>
        <br>
        <input type="submit" value="Submit" class="button">
        <a href="user.php" class="back-button">Back</a>
        </form>
    </div>
</body>

</html>
