<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$songs = $pdo->query("
SELECT 
    s.SongID, 
    s.Title AS SongName, 
    s.ArtistName, 
    s.Genre, 
    k.Title AS VersionName
FROM 
    Song s
JOIN 
    KaraokeFiles k ON s.SongID = k.SongID
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

    <div class="dj-body">
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
            <div class="playlistContainer">
                <table id="songTable">
                        <tr class="headcolumn">
                            <th>Cover</th>
                            <th class="clickable-header" onclick="sortTable(1, 'songTable')"><a>Song</a></th>
                            <th class="clickable-header" onclick="sortTable(2, 'songTable')">Artist</th>
                            <th class="clickable-header" onclick="sortTable(3, 'songTable')">Genre</th>
                        </tr>
                    <?php if (!empty($songs)) : ?>
                        <?php foreach ($songs as $song) : ?>
                            <?php
                            $songImage = "song_tb/" . $song['SongName'] . ".jpg";
                            $defaultImage = "song_tb/404.gif"; // path to stock image
                            $songCover = file_exists($songImage) ? $songImage : $defaultImage;
                            ?>
                            <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['SongName']; ?>', this)">
                                <!-- Add folder song_tb to public_html directory -->
                                <td><img src="<?php echo $songCover; ?>" alt="Song Cover" class="songCover"></td>
                                <td><?php echo $song['SongName']; ?></td>
                                <td><?php echo $song['ArtistName']; ?></td>
                                <td><?php echo $song['Genre']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>
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
<style>
.playlistContainer{
    height: 500px; /* Adjust as needed */
    overflow: auto;
}
</style>

</html>
