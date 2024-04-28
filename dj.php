<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// $normalQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NULL OR q.Price = 0")->fetchAll();
// $priorityQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NOT NULL AND q.Price <> 0")->fetchAll();


$normalQueue = $pdo->query("
SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName, s.KaraokeFileID,
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
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>DJ Page</title>
</head>

<body>
    <h2>Normal Queue</h2>
    <table>
        <tr>
            <th>Queue ID</th>
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
            <tr>
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
    <h2>Priority Queue</h2>
    <table>
        <tr>
            <th>Queue ID</th>
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
        <?php foreach ($priorityQueue as $queueItem) : ?>
            <tr>
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


    <div>
        <a href="ind.php" class="back-button">Back</a>
    </div>

</body>

</html>
