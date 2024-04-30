<?php
include 'db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$normalQueue = $pdo->query("
SELECT * FROM Queue q 
JOIN KaraokeFiles k ON q.FileID = k.FileID
JOIN Song s ON k.SongID = s.SongID
WHERE q.Price IS NULL OR q.Price = 0
GROUP BY q.QueueID
")->fetchAll();

$priorityQueue = $pdo->query("
SELECT * FROM Queue q 
JOIN KaraokeFiles k ON q.FileID = k.FileID
JOIN Song s ON k.SongID = s.SongID
WHERE q.Price IS NOT NULL AND q.Price <> 0
GROUP BY q.QueueID
")->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">

        <script>
        function sortTable()
        {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementsByTagName("table")[0];

            
        }
       
        </script>

    <title>DJ Page</title>
</head>

<body>
    <div class="dj-body">
        <h1 class="header">DJ Dashboard</h1>
        <p class="form-label">Welcome to the DJ Dashboard! Here, you can view the queue and manage the songs.</p>
        <h2>Normal Queue</h2>
        <br>
        <br>
        <table id="normalQueueTable">
            <tr>
            <th class="clickable-header" onclick="sortTable(0, 'priorityQueueTable')">Order</th>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Version</th>
                <th>User Name</th>
            </tr>
            <?php foreach ($normalQueue as $queueItem) : ?>
                <tr onclick="selectQueue(this, 'priorityQueueTable')">
                    <td><?php echo $queueItem['QueueID']; ?></td>
                    <td><?php echo $queueItem['Title']; ?></td>
                    <td><?php echo $queueItem['ArtistName']; ?></td>
                    <td><?php echo $queueItem['Genre']; ?></td>
                    <td><?php echo $queueItem['Version']; ?></td>
                    <td><?php echo $queueItem['Username']; ?></td>
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
                <th class="clickable-header" onclick="sortTable(0, 'priorityQueueTable')">Order</th>
                <th>Song Name</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Version</th>
                <th>User Name</th>
                <th class="clickable-header" onclick="sortTable(9, 'priorityQueueTable')">Price</th>
            </tr>
            <?php foreach ($priorityQueue as $queueItem) : ?>
                <tr onclick="selectQueue(this, 'priorityQueueTable')">
                    <td><?php echo $queueItem['QueueID']; ?></td>
                    <td><?php echo $queueItem['Title']; ?></td>
                    <td><?php echo $queueItem['ArtistName']; ?></td>
                    <td><?php echo $queueItem['Genre']; ?></td>
                    <td><?php echo $queueItem['Version']; ?></td>
                    <td><?php echo $queueItem['Username']; ?></td>
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