<?php
include 'db_connect.php';

// $normalQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NULL OR q.Price = 0")->fetchAll();
// $priorityQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, q.Price FROM Queue q JOIN User u ON q.UserID = u.UserID JOIN Song s ON q.SongID = s.SongID WHERE q.Price IS NOT NULL AND q.Price <> 0")->fetchAll();





/*$normalQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName, 
GROUP_CONCAT(DISTINCT c.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT r.RoleName SEPARATOR ', ') AS Roles, q.Price 
FROM Queue q 
JOIN User u ON q.UserID = u.UserID 
JOIN Song s ON q.SongID = s.SongID 
JOIN Artist a ON s.ArtistID = a.ArtistID
JOIN Genre g ON s.GenreID = g.GenreID
JOIN VersionOfSong v ON s.SongID = v.SongID
JOIN SongContributor sc ON s.SongID = sc.SongID
JOIN Contributor c ON sc.ContributorID = c.ContributorID
JOIN Role r ON c.RoleID = r.RoleID
WHERE q.Price IS NULL OR q.Price = 0
GROUP BY q.QueueID
")->fetchAll();

$priorityQueue = $pdo->query("SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName, 
GROUP_CONCAT(DISTINCT c.ContributorName SEPARATOR ', ') AS Contributors,
GROUP_CONCAT(DISTINCT r.RoleName SEPARATOR ', ') AS Roles, q.Price 
FROM Queue q 
JOIN User u ON q.UserID = u.UserID 
JOIN Song s ON q.SongID = s.SongID 
JOIN Artist a ON s.ArtistID = a.ArtistID
JOIN Genre g ON s.GenreID = g.GenreID
JOIN VersionOfSong v ON s.SongID = v.SongID
JOIN SongContributor sc ON s.SongID = sc.SongID
JOIN Contributor c ON sc.ContributorID = c.ContributorID
JOIN Role r ON c.RoleID = r.RoleID
WHERE q.Price IS NOT NULL AND q.Price <> 0
GROUP BY q.QueueID
")->fetchAll();*/

$normalQueue = $pdo->query("
SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName, 
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
SELECT q.QueueID, u.UserName, s.SongName, a.ArtistName, g.GenreName, v.VersionName, 
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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 0.5rem;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td {
            background-color: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-button {
            bottom: 0;
            left: 0;
            display: inline-block;
            padding: 15px 25px;
            margin-top: 20px;
            color: #fff;
            background-color: #ff43a4;
            font-size: 18px;
            /* Neon green for buttons */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            /* Smooth transition */
            box-shadow: 0 0 5px #ff43a4,
                /* Inner glow */
                0 0 10px #ff43a4,
                /* Middle glow */
                0 0 15px #ff43a4,
                /* Outer glow */
                0 0 2px #ff43a4;
            /* Far outer glow */
        }

        .back-button:hover {
            background-color: #00ff41;
            /* Neon pink for button hover */
            box-shadow: 0 0 5px #00ff41,
                /* Inner glow */
                0 0 10px #00ff41,
                /* Middle glow */
                0 0 15px #00ff41,
                /* Outer glow */
                0 0 5px #00ff41;
            /* Far outer glow */
        }

        h2 {
            color: #333;
            text-align: center;
        }
    </style>


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
                <td><?php echo $queueItem['VersionName']; ?></td>
                <td><?php echo $queueItem['Contributors']; ?></td>
                <td><?php echo $queueItem['Roles']; ?></td>
                <td><?php echo $queueItem['UserName']; ?></td>
                <td><?php echo $queueItem['Price']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Priority Queue</h2>
    <table>
        <tr>
            <th>Queue ID</th>
            <th>Song Name</th>
            <th>Artist</th>
            <th>Genre</th>
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
