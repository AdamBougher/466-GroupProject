<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*** !Update  query to create.sql ***/
$users = $pdo->query("SELECT * FROM User")->fetchAll();


$songs = $pdo->query("
SELECT 
    s.SongID, 
    s.SongName, 
    a.ArtistName, 
    g.GenreName, 
    v.VersionName, 
    GROUP_CONCAT(DISTINCT c.ContributorName SEPARATOR ', ') AS Contributors,
    GROUP_CONCAT(DISTINCT r.RoleName SEPARATOR ', ') AS Roles
FROM 
    Song s
JOIN 
    Artist a ON s.ArtistID = a.ArtistID
JOIN 
    Genre g ON s.GenreID = g.GenreID
JOIN 
    VersionOfSong v ON s.SongID = v.SongID
LEFT JOIN 
    SongContributor sc ON s.SongID = sc.SongID
LEFT JOIN 
    Contributor c ON sc.ContributorID = c.ContributorID
LEFT JOIN 
    Role r ON c.RoleID = r.RoleID
GROUP BY 
    s.SongID, v.VersionName;
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
            <table id="songTable">
                <tr>
                    <th>Cover</th>
                    <th>Song</th>
                    <th>Artist</th>
                    <th>Genre</th>
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
                            <td><?php echo $song['SongName'] . " - " . $song['VersionName']; ?></td>
                            <td><?php echo $song['ArtistName']; ?></td>
                            <td><?php echo $song['GenreName']; ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>
            </table>


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
