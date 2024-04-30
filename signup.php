<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$users = $pdo->query("SELECT * FROM User")->fetchAll();
/*$songs = $pdo->query("SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
JOIN SongContributor ON Song.SongID = SongContributor.SongID
JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Song.SongID, VersionOfSong.VersionName;")->fetchAll();*/


$songs = $pdo->query("
SELECT Song.SongID, Song.SongName, Artist.ArtistName, Genre.GenreName, VersionOfSong.VersionName, 
GROUP_CONCAT(DISTINCT Contributor.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT Role.RoleName SEPARATOR ', ') AS Roles
FROM Song
JOIN Artist ON Song.ArtistID = Artist.ArtistID
JOIN Genre ON Song.GenreID = Genre.GenreID
JOIN VersionOfSong ON Song.SongID = VersionOfSong.SongID
LEFT JOIN SongContributor ON Song.SongID = SongContributor.SongID
LEFT JOIN Contributor ON SongContributor.ContributorID = Contributor.ContributorID
LEFT JOIN Role ON Contributor.RoleID = Role.RoleID
GROUP BY Song.SongID, VersionOfSong.VersionName;
")->fetchAll();


$queues = $pdo->query("SELECT * FROM Queue")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title>Sign Up to Sing - Karaoke Event Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js"></script>
    <link rel="icon" href="icon.png" type="image/x-icon">
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
        <table id="songTable">
            <tr>
                <th>Song</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Version</th>
                <th>Contributor</th>
                <th>Role</th>
            </tr>
            <?php if (!empty($songs)) : ?>
                <?php foreach ($songs as $song) : ?>
                    <tr onclick="selectSong('<?php echo $song['SongID']; ?>', '<?php echo $song['SongName']; ?>', this)">
                        <td><?php echo $song['SongName']; ?></td>
                        <td><?php echo $song['ArtistName']; ?></td>
                        <td><?php echo $song['GenreName']; ?></td>
                        <td><?php echo $song['VersionName']; ?></td>
                        <td><?php echo $song['Contributors']; ?></td>
                        <td><?php echo $song['Roles']; ?></td>
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
