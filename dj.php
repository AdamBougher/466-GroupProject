<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// $normalQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NULL OR q.Price = 0")->fetchAll();
// $priorityQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NOT NULL AND q.Price <> 0")->fetchAll();

session_start();

if (!isset($_SESSION['playlist'])) {
    $_SESSION['playlist'] = array();
}

if (!isset($_SESSION['current_song'])) {
    $_SESSION['current_song'] = null;
}



$normalQueue = $pdo->query("
SELECT q.QueueID, q.Username, s.Title AS SongName, s.ArtistName, s.Genre AS GenreName, kf.Version AS VersionName, s.FileID AS KaraokeFileID,
GROUP_CONCAT(DISTINCT c.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT r.RoleName SEPARATOR ', ') AS Roles, q.Price 
FROM Queue q 
JOIN Song s ON q.SongID = s.SongID 
LEFT JOIN SongContributor sc ON s.SongID = sc.SongID
LEFT JOIN Contributor c ON sc.ContributorID = c.ContributorID
LEFT JOIN Role r ON c.RoleID = r.RoleID
JOIN KaraokeFiles kf ON s.FileID = kf.FileID
WHERE q.Price IS NULL OR q.Price = 0
GROUP BY q.QueueID
")->fetchAll();


$priorityQueue = $pdo->query("
SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName , s.KaraokeFileID, 
GROUP_CONCAT(DISTINCT c.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT r.RoleName SEPARATOR ', ') AS Roles, q.Price 
FROM Queue q 
JOIN User u ON q.UserID = u.UserID 
JOIN Song s ON q.SongID = s.SongID 
JOIN Artist a ON s.ArtistID = a.ArtistID
JOIN Genre g ON s.GenreID = g.GenreID
JOIN VersionOfSong v ON s.SongID = v.SongID
LEFT JOIN SongContributor sc ON s.SongID = sc.SongID
LEFT JOIN Contributor c ON sc.ContributorID = c.ContributorID
LEFT JOIN Role r ON c.RoleID = r.RoleID
WHERE q.Price IS NOT NULL AND q.Price <> 0
GROUP BY q.QueueID
")->fetchAll();




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>DJ Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js"></script>
</head>

<body>
    <div class="dj-body">
        <h1 class="header">DJ Dashboard</h1>
        <p class="form-label">Welcome to the DJ Dashboard! Here, you can view the queue and manage the songs.</p>
        <h2>Normal Queue</h2>
        <br>
        <br>
        <table id="normalQueueTable">
    <h2>Normal Queue</h2>
    <table>
        <tr>
            <th>Queue  ID</th>
            <th>Song Name</th>
            <th>Artist</th>
            <th>Genre</th>
            <th>FileID</th>
            <th>Version</th>
            <th>User Name</th>
            <th>Price</th>
        </tr>
        <?php foreach ($normalQueue as $queueItem) : ?>
            <tr>
                <th class="clickable-header" onclick="sortTable(0, 'normalQueueTable')">Queue ID</th>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>FileID</th>
                <th>Version</th>
                <th>Contributors</th>
                <th>Roles</th>
                <th>User Name</th>
                <th>Price</th>
            </tr>
            <?php foreach ($normalQueue as $queueItem) : ?>
                <tr onclick="selectQueue(this, 'normalQueueTable')">
                    <td><?php echo $queueItem['QueueID']; ?></td>
                    <td><?php echo $queueItem['SongName']; ?></td>
                    <td><?php echo $queueItem['ArtistName']; ?></td>
                    <td><?php echo $queueItem['Genre']; ?></td>
                    <td><?php echo $queueItem['VersionName']; ?></td>
                    <td><?php echo $queueItem['UserName']; ?></td>
                    <td><?php echo $queueItem['Price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <br>
        <h2>Priority Queue</h2>
        <br>
        <br>
        <table id="priorityQueueTable">
            <tr>
                <th class="clickable-header" onclick="sortTable(0, 'priorityQueueTable')">Queue ID</th>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>FileID</th>
                <th>Version</th>
                <th>Contributors</th>
                <th>Roles</th>
                <th>User Name</th>
                <th class="clickable-header" onclick="sortTable(9, 'priorityQueueTable')">Price</th>
            </tr>
            <?php foreach ($priorityQueue as $queueItem) : ?>
                <tr onclick="selectQueue(this, 'priorityQueueTable')">
                    <td><?php echo $queueItem['QueueID']; ?></td>
                    <td><?php echo $queueItem['SongName']; ?></td>
                    <td><?php echo $queueItem['ArtistName']; ?></td>
                    <td><?php echo $queueItem['GenreName']; ?></td>
                    <td><?php echo $queueItem['KaraokeFileID']; ?></td>
                    <td><?php echo $queueItem['VersionName']; ?></td>
                    <td><?php echo $queueItem['Contributors']; ?></td>
                    <td><?php echo $queueItem['Roles']; ?></td>
                    <td><?php echo $queueItem['UserName']; ?></td>
                    <td><?php echo $queueItem['Price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <br>
        <button onclick="addToPlaylist()" class="button" type="button">Add to Playlist</button>

        <!-- Playlist -->
        <h2>Playlist</h2>
        <br>
        <br>
        <table id="playlistTable">
            <tr>
                <th>Song Name</th>
                <th>Artist</th>
            </tr>
            <?php foreach ($_SESSION['playlist'] as $song) : ?>
                <tr>
                    <td><?php echo $song['song']; ?></td>
                    <td><?php echo $song['artist']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>


        <br>
        <br>
        <!-- Currently Playing Song -->
        <h2>Currently Playing</h2>
        <?php if ($_SESSION['current_song'] !== null) : ?>
            <p class="form-label">Song: <?php echo $_SESSION['current_song']['song']; ?></p>
            <p class="form-label">Artist: <?php echo $_SESSION['current_song']['artist']; ?></p>
        <?php else : ?>
            <p class="form-label">No song is currently playing.</p>
        <?php endif; ?>

        <br>

        <button onclick="nextSong()" class="button" type="button">Next Song</button>
        <a href="admin.php" class="button">Admin</a>

        <a href="ind.php" class="back-button">Back</a>
    </div>

</body>

</html>