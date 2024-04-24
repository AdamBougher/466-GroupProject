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



        <h2>PLayList</h2>
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

    </div>
</body>

</html>
