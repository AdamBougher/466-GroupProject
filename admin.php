<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">

<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js"></script>
=======
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="styles.css">    
>>>>>>> 735c943 (Styles & unified js file)
</head>

<body class="admin-body">
    <form action="reset_db.php" method="post" onsubmit="showLoader()">
        <button type="submit" class="button">Rebuild Database</button>
    </form>

    <div id="loader" class="loader"></div>

    <form action="clear_queue.php" method="post">
        <button type="submit" class="button">Clear Queue</button>
    </form>

    <form action="clear_playlist.php" method="post">
        <button type="submit" class="button">Clear Playlist</button>
    </form>

    <div>
        <a href="ind.php" class="back-button">Back</a>
    </div>


</body>

</html>
